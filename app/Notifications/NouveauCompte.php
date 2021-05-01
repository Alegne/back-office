<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouveauCompte extends Notification
{
    use Queueable;

    public $email;
    /**
     * @var string
     */
    public $numero;
    /**
     * @var string
     */
    public $identifiant;


    public $HOME;
    /**
     * @var bool
     */
    public $back;
    /**
     * @var null
     */
    public $nom;

    /**
     * Create a new notification instance.
     *
     * @param $email
     * @param bool $back
     * @param string $numero
     * @param string $identifiant
     * @param null $nom
     */
    public function __construct($email, $back = false, $numero = null, $identifiant = null, $nom = null)
    {
        //
        $this->email       = $email;
        $this->numero      = $numero;
        $this->identifiant = $identifiant;
        $this->back        = $back;
        # $this->HOME        = $back ? route('dashboard.webcup') : config('app.front_office');
        $this->HOME        = config('app.front_office') ? config('app.front_office') : route('dashboard.webcup');
        $this->nom         = $nom;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /*return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!')
            ;*/
        return (new MailMessage)
            ->subject("Creation d'une compte dans ENI")
            ->view(
            'emails.verify-account',
            [
                'email'       => $this->email,
                'numero'      => $this->numero,
                'identifiant' => $this->identifiant,
                'url'         => config('app.front_office'),
                'nom'         => $this->nom
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
