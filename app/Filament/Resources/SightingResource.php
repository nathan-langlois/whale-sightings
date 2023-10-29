<?php

namespace App\Filament\Resources;

use App\Enums\SightingTypeEnum;
use App\Filament\Resources\SightingResource\Pages;
use App\Models\Sighting;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class SightingResource extends Resource
{
    protected static ?string $model = Sighting::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
        
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->label('Sighting Type')
                    ->options(SightingTypeEnum::selectable())
                    ->required(),
                Forms\Components\DateTimePicker::make('when')
                    ->required(),
                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('notes')
                    ->label('Observation Notes')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_url')
                    ->label('Photograph Image URL(s)')
                    ->columnSpanFull(),
                //Forms\Components\Select::make('user_id')
                //    ->relationship('user', 'name')
                //    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('when')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Sighting Type')
                    ->options(SightingTypeEnum::selectable()),
                Filter::make('sighted_before')
                    ->form([
                        DatePicker::make('sighted_before'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $query
                            ->when(
                                $data['sighted_before'],
                                fn (Builder $query, $date): Builder => $query->whereDate('when', '<=', strval($date)),
                            );
                        abort_unless($query instanceof Builder, 504);
                        return $query;
                    })
                    ->indicateUsing(function (array $data): ?string {
                        $date = $data['sighted_before'];

                        return $date ? 'Sighted before: '. $date : null;
                    }),
                Filter::make('sighted_after')
                    ->form([
                        DatePicker::make('sighted_after'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $query
                            ->when(
                                $data['sighted_after'],
                                function (Builder $query, $date): Builder {
                                    return $query->whereDate('when', '>=', strval($date));
                                }
                            );
                        abort_unless($query instanceof Builder, 504);
                        return $query;
                    })
                    ->indicateUsing(function (array $data): ?string {
                        $date = $data['sighted_after'];

                        return $date ? 'Sighted after: '. $date : null;
                    }),
                Tables\Filters\TrashedFilter::make(),
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->defaultSort('when', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSightings::route('/'),
            'create' => Pages\CreateSighting::route('/create'),
            'edit' => Pages\EditSighting::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
