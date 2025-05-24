<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id', 'email', 'amount', 'currency', 'order_code',
        'status', 'pay_method', 'transaction_id', 'description'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
