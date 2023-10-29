<?php

namespace App\Filament\Resources;

use App\Enums\SightingTypeEnum;
use App\Facades\TypeAs;
use App\Filament\Resources\SightingResource\Pages;
use App\Filament\Resources\SightingResource\RelationManagers;
use App\Models\Sighting;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SightingResource extends Resource
{
    protected static ?string $model = Sighting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_url')
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
                Filter::make('sighted_on_or_after')
                    ->form([
                        DatePicker::make('sighted_on_or_after'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $query
                            ->when(
                                $data['sighted_on_or_after'],
                                function (Builder $query, $date): Builder {
                                    return $query->whereDate('when', '>=', strval($date));
                                }
                            );
                        abort_unless($query instanceof Builder, 504);
                        return $query;
                    })
                    ->indicateUsing(function (array $data): ?string {
                        $date = $data['sighted_on_or_after'];

                        return $date ? 'Sighted on or after: '. $date : null;
                    }),
                Filter::make('sighted_by_or_before')
                    ->form([
                        DatePicker::make('sighted_by_or_before'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $query
                            ->when(
                                $data['sighted_by_or_before'],
                                fn (Builder $query, $date): Builder => $query->whereDate('when', '<=', strval($date)),
                            );
                        abort_unless($query instanceof Builder, 504);
                        return $query;
                    })
                    ->indicateUsing(function (array $data): ?string {
                        $date = $data['sighted_by_or_before'];

                        return $date ? 'Sighted by or before: '. $date : null;
                    }),
                //Tables\Filters\TrashedFilter::make(),
            ], layout: FiltersLayout::AboveContent)
            ->defaultSort('when', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
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
