<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The payment status.
     *
     * @var
     */
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(formatTitle([$this->status == 'completed' ? __('Payment completed') : __('Payment cancelled'), config('settings.title')]))
            ->markdown('vendor.notifications.email', [
                'introLines' => [$this->status == 'completed' ? (__('The payment was successful.') . ' ' . __('Thank you!')) : __('The payment was cancelled.')],
                'actionText' => __('Dashboard'),
                'actionUrl' => route('dashboard')
            ]);
    }
}
