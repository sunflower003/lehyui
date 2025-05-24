<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReplyCommentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $parentUser; // Người bị rep
    public $replyUser;  // Người rep
    public $comment;    // Nội dung rep
    public $post;       // Bài viết

    public function __construct($parentUser, $replyUser, $comment, $post)
    {
        $this->parentUser = $parentUser;
        $this->replyUser = $replyUser;
        $this->comment = $comment;
        $this->post = $post;
    }

    public function build()
    {
        return $this->subject('Bạn có bình luận mới trả lời trên LehyUI')
            ->view('emails.reply_comment_notification');
    }
}