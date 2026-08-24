<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use App\Models\SiteSetting;

class SiteAppearance extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $navigationGroup = 'Settings';
    protected static string $view = 'filament.pages.site-appearance';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::first();
        if ($settings) {
            $this->form->fill($settings->toArray());
        } else {
            $this->form->fill();
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Logos & Icons')
                    ->description('Upload custom logos and favicons. Leave blank to use the default ones.')
                    ->schema([
                        \Awcodes\Curator\Components\Forms\CuratorPicker::make('favicon')
                            ->label('Favicon')
                            ->directory('site')
                            ->extraAttributes(['style' => 'max-width: 200px; margin: 0 auto;']),
                            
                        \Awcodes\Curator\Components\Forms\CuratorPicker::make('header_logo')
                            ->label('Header Logo (Main)')
                            ->directory('site')
                            ->extraAttributes(['style' => 'max-width: 200px; margin: 0 auto;']),
                            
                        \Awcodes\Curator\Components\Forms\CuratorPicker::make('footer_logo')
                            ->label('Footer Logo (Light)')
                            ->directory('site')
                            ->extraAttributes(['style' => 'max-width: 200px; margin: 0 auto;']),
                    ])
                    ->columns(3),
                    
                Section::make('Home Page Hero')
                    ->description('Configure the main hero banner on the home page')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('home_hero_top_text')
                            ->label('Top Small Text')
                            ->placeholder('Vietnam · Cambodia · Laos · Thailand'),
                        \Filament\Forms\Components\Textarea::make('home_hero_headline')
                            ->label('Main Headline')
                            ->placeholder('Journeys that leave you better than they found you.')
                            ->rows(2)
                            ->columnSpanFull(),
                        \Filament\Forms\Components\Textarea::make('home_hero_subtitle')
                            ->label('Subtitle / Description')
                            ->placeholder('Solvive designs small-group and private luxury travel across Southeast Asia...')
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        \Filament\Forms\Components\Grid::make(2)
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('home_hero_btn1_text')
                                    ->label('Button 1 Text')
                                    ->placeholder('Explore Small Group Tours'),
                                \Filament\Forms\Components\TextInput::make('home_hero_btn1_link')
                                    ->label('Button 1 Link')
                                    ->placeholder('/small-group-tours'),
                                \Filament\Forms\Components\TextInput::make('home_hero_btn2_text')
                                    ->label('Button 2 Text')
                                    ->placeholder('Book a Free Consultation'),
                                \Filament\Forms\Components\TextInput::make('home_hero_btn2_link')
                                    ->label('Button 2 Link')
                                    ->placeholder('/contact#consult'),
                            ]),

                        \Filament\Forms\Components\Grid::make(3)
                            ->schema([
                                \Filament\Forms\Components\Fieldset::make('Stat 1')
                                    ->schema([
                                        \Filament\Forms\Components\TextInput::make('home_hero_stat1_value')
                                            ->label('Value')
                                            ->placeholder('Small Group'),
                                        \Filament\Forms\Components\TextInput::make('home_hero_stat1_title')
                                            ->label('Title')
                                            ->placeholder('Group Journeys'),
                                    ])->columns(1),
                                \Filament\Forms\Components\Fieldset::make('Stat 2')
                                    ->schema([
                                        \Filament\Forms\Components\TextInput::make('home_hero_stat2_value')
                                            ->label('Value')
                                            ->placeholder('4'),
                                        \Filament\Forms\Components\TextInput::make('home_hero_stat2_title')
                                            ->label('Title')
                                            ->placeholder('Countries Explored'),
                                    ])->columns(1),
                                \Filament\Forms\Components\Fieldset::make('Stat 3')
                                    ->schema([
                                        \Filament\Forms\Components\TextInput::make('home_hero_stat3_value')
                                            ->label('Value')
                                            ->placeholder('24/7'),
                                        \Filament\Forms\Components\TextInput::make('home_hero_stat3_title')
                                            ->label('Title')
                                            ->placeholder('Local On-Call Support'),
                                    ])->columns(1),
                            ]),
                        
                        \Awcodes\Curator\Components\Forms\CuratorPicker::make('home_hero_image')
                            ->label('Hero Banner Image')
                            ->directory('site')
                            ->extraAttributes(['style' => 'max-width: 400px;'])
                            ->columnSpanFull(),
                    ]),

                Section::make('Footer & Contact Info')
                    ->schema([
                        \Filament\Forms\Components\Textarea::make('footer_text')
                            ->label('Footer Text (Below Logo)')
                            ->rows(3),
                        \Filament\Forms\Components\TextInput::make('copyright_text')
                            ->label('Copyright Text'),
                        \Filament\Forms\Components\TextInput::make('bottom_right_text')
                            ->label('Bottom Right Text'),
                        \Filament\Forms\Components\TextInput::make('email_id')
                            ->label('Email Address')
                            ->email(),
                        \Filament\Forms\Components\TextInput::make('phone_number')
                            ->label('Phone Number'),
                        \Filament\Forms\Components\Textarea::make('address')
                            ->label('Address')
                            ->rows(3),
                        \Filament\Forms\Components\TextInput::make('social_ig')
                            ->label('Instagram URL')
                            ->url(),
                        \Filament\Forms\Components\TextInput::make('social_fb')
                            ->label('Facebook URL')
                            ->url(),
                        \Filament\Forms\Components\TextInput::make('social_p')
                            ->label('Pinterest URL')
                            ->url(),
                        \Filament\Forms\Components\TextInput::make('social_li')
                            ->label('LinkedIn URL')
                            ->url(),
                        \Filament\Forms\Components\TextInput::make('social_tw')
                            ->label('Twitter / X URL')
                            ->url(),
                        \Filament\Forms\Components\TextInput::make('social_yt')
                            ->label('YouTube URL')
                            ->url(),
                        \Filament\Forms\Components\Toggle::make('social_open_new_tab')
                            ->label('Open Social Links in New Tab')
                            ->default(true)
                            ->columnSpanFull(),
                    ])->columns(2)
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $settings = SiteSetting::firstOrCreate([]);
        $settings->update($this->form->getState());

        Notification::make()
            ->title('Site appearance saved!')
            ->success()
            ->send();
    }
}
