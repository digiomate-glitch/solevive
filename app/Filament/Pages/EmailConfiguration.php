<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class EmailConfiguration extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Settings';
    protected static string $view = 'filament.pages.email-configuration';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'MAIL_MAILER' => env('MAIL_MAILER'),
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('SMTP Credentials')
                    ->description('Update your email server settings here. These will be saved to your .env file.')
                    ->schema([
                        TextInput::make('MAIL_MAILER')->label('Mailer (e.g. smtp, log)')->required(),
                        TextInput::make('MAIL_HOST')->label('Mail Host')->required(),
                        TextInput::make('MAIL_PORT')->label('Mail Port')->numeric()->required(),
                        TextInput::make('MAIL_USERNAME')->label('Mail Username'),
                        TextInput::make('MAIL_PASSWORD')->label('Mail Password')->password(),
                        TextInput::make('MAIL_ENCRYPTION')->label('Mail Encryption (e.g. tls, ssl)'),
                        TextInput::make('MAIL_FROM_ADDRESS')->label('From Address')->email()->required(),
                        TextInput::make('MAIL_FROM_NAME')->label('From Name')->required(),
                    ])
                    ->columns(2)
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $envFile = app()->environmentFilePath();
        $envContents = File::get($envFile);

        foreach ($data as $key => $value) {
            $value = $value ?? '';
            // If value contains spaces, quote it
            if (preg_match('/\s/', $value)) {
                $value = '"' . $value . '"';
            }
            
            // Check if key exists
            if (preg_match("/^{$key}=/m", $envContents)) {
                $envContents = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContents);
            } else {
                $envContents .= "\n{$key}={$value}\n";
            }
        }

        File::put($envFile, $envContents);
        Artisan::call('config:clear');

        Notification::make()
            ->title('Email configuration saved!')
            ->success()
            ->send();
    }
}
