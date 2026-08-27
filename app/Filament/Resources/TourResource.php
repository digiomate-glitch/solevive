<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-globe-americas';
    protected static \UnitEnum|string|null $navigationGroup = 'Tours';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tour Details')->tabs([
                    Forms\Components\Tabs\Tab::make('Basic Info')->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $state, Forms\Set $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('categories')
                            ->multiple()
                            ->relationship('categories', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('duration_days')
                            ->numeric(),
                        Forms\Components\TextInput::make('destinations_count')
                            ->numeric(),
                        Forms\Components\TextInput::make('countries')
                            ->label('Countries List (e.g. Vietnam · Cambodia · Laos)')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('price')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('max_guests')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('featured_badge')
                            ->label('Featured Badge Text')
                            ->placeholder('e.g. FEATURED JOURNEY')
                            ->maxLength(255),
                        Forms\Components\ColorPicker::make('badge_color')
                            ->label('Featured Badge & Border Color')
                            ->placeholder('e.g. #00877C'),
                        Forms\Components\TextInput::make('banner_text')
                            ->label('Banner Text')
                            ->placeholder('e.g. Booking Ends April 5th, 2027')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Repeater::make('facts')
                            ->label('Tour Facts (4 columns)')
                            ->schema([
                                Forms\Components\TextInput::make('top')->label('Top Text (e.g. 13 or Private)')->required(),
                                Forms\Components\TextInput::make('bottom')->label('Bottom Text (e.g. DAYS or JUST YOUR GROUP)')->required(),
                            ])
                            ->columns(2)
                            ->maxItems(4)
                            ->columnSpanFull(),
                    ])->columns(2),
                    
                    Forms\Components\Tabs\Tab::make('Content & Media')->schema([
                        \Awcodes\Curator\Components\Forms\CuratorPicker::make('hero_image')
                            ->directory('tours'),
                        \Awcodes\Curator\Components\Forms\CuratorPicker::make('overview_image')
                            ->directory('tours'),
                        Forms\Components\Textarea::make('hero_text')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('overview_heading')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('overview_desc')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('highlights_heading')
                            ->label('Highlights Heading (e.g. What awaits you.)')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('differences_heading')
                            ->label('Differences Heading (e.g. Why Choose an A&K Small Group Journey?)')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('inclusions_heading')
                            ->label('Inclusions Heading (e.g. Every detail, handled.)')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('accommodations_heading')
                            ->label('Accommodations Heading (e.g. Exceptional Properties.)')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('additional_infos_heading')
                            ->label('Additional Info Heading (e.g. Additional information.)')
                            ->columnSpanFull(),
                    ])->columns(2),

                    Forms\Components\Tabs\Tab::make('Related Data')->schema([
                        Forms\Components\Repeater::make('highlights')
                            ->relationship()
                            ->schema([
                                \Kahusoftware\FilamentCkeditorField\CKEditor::make('content')->required(),
                                Forms\Components\TextInput::make('sort_order')->numeric()->default(0)
                            ])->columns(2)->orderColumn('sort_order'),

                        Forms\Components\Repeater::make('differences')
                            ->relationship()
                            ->label('The A&K Difference')
                            ->schema([
                                \Kahusoftware\FilamentCkeditorField\CKEditor::make('content')->required(),
                                Forms\Components\TextInput::make('sort_order')->numeric()->default(0)
                            ])->columns(2)->orderColumn('sort_order'),

                        Forms\Components\Repeater::make('inclusions')
                            ->relationship()
                            ->schema([
                                \Kahusoftware\FilamentCkeditorField\CKEditor::make('content')->required(),
                                Forms\Components\TextInput::make('sort_order')->numeric()->default(0)
                            ])->columns(2)->orderColumn('sort_order'),
                        
                        Forms\Components\Repeater::make('accommodations')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('hotel_name'),
                                Forms\Components\Textarea::make('description'),
                                \Awcodes\Curator\Components\Forms\CuratorPicker::make('image')
                                    ->directory('hotels'),
                                Forms\Components\TextInput::make('sort_order')->numeric()->default(0)
                            ])->columns(2)->orderColumn('sort_order'),

                        Forms\Components\Repeater::make('additionalInfos')
                            ->relationship()
                            ->schema([
                                \Kahusoftware\FilamentCkeditorField\CKEditor::make('content')->required(),
                                Forms\Components\TextInput::make('sort_order')->numeric()->default(0)
                            ])->columns(2)->orderColumn('sort_order'),
                    ]),
                    Forms\Components\Tabs\Tab::make('SEO Settings')->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('seo_desc')
                            ->label('Meta Description')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('primary_keyword')
                            ->label('Primary Keyword')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('focus_keyword')
                            ->label('Focus Keyword')
                            ->maxLength(255),
                    ])->columns(1),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('categories.name')->badge(),
                Tables\Columns\TextColumn::make('price')->searchable(),
                Tables\Columns\TextColumn::make('duration_days')->numeric()->sortable(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }
}
