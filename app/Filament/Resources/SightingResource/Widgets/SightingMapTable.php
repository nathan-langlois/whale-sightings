<?php

namespace App\Filament\Resources\SightingResource\Widgets;

use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Cheesegrits\FilamentGoogleMaps\Widgets\MapTableWidget;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class SightingMapTable extends MapTableWidget
{
	protected static ?string $heading = 'Sightings Map';

	protected static ?int $sort = 1;

	protected static ?string $pollingInterval = null;

	protected static ?bool $clustering = true;

	protected static ?string $mapId = 'sightings';

	protected int | string | array $columnSpan = 'full';

	protected function getTableQuery(): Builder
	{
		return \App\Models\Sighting::query()->orderByDesc('when'); //->latest();
	}

	protected function getTableColumns(): array
	{
		return [
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
				->sortable()
				->searchable(),
			/*MapColumn::make('location')
				->extraImgAttributes(
					fn ($record): array => ['title' => $record->latitude . ',' . $record->longitude]
				)
				->height('150')
				->width('250')
				->type('hybrid')
				->zoom(15),*/
		];
	}

	protected function getTableFilters(): array
	{
		return [
			RadiusFilter::make('location')
				->section('Radius Filter')
				->selectUnit(),
            //MapIsFilter::make('map'),
		];
	}

	protected function getTableActions(): array
	{
		return [
			Tables\Actions\ViewAction::make(),
			//Tables\Actions\EditAction::make(),
			//GoToAction::make()
			//	->zoom(14),
			//RadiusAction::make(),
		];
	}

	protected function getData(): array
	{
		$locations = $this->getRecords();

		$data = [];

		foreach ($locations as $location)
		{
			$data[] = [
				'location' => [
					'lat' => $location->latitude ? round(floatval($location->latitude), static::$precision) : 0,
                    'lng' => $location->longitude ? round(floatval($location->longitude), static::$precision) : 0,
				],
                'id'      => $location->id,
			];
		}

		return $data;
	}
}
