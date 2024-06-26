<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLogs extends Model
{
    use HasFactory;
    protected $table = 'activity_logs';

    protected $fillable = ['log_type', 'model', 'message', 'data', 'user_id'];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->select(['id', 'name']);;
    }

    public static function createLogs($data)
    {
        try {
            DB::connection('mysql')->beginTransaction();
            $author = auth()->user()->name ?? '';
            $data['message'] = str_replace('&nbsp;', '', $data['message']);
            $payload = [
                'log_type' => isset($data['log_type']) ? $data['log_type'] : '',
                'model' => isset($data['model']) ? $data['model'] : '',
                'message' => isset($data['message']) ? $data['message'] : '',
                'data' => isset($data['data']) ? $data['data'] : '',
                'user_id' => auth() ?  auth()->id() : 0
            ];

            ActivityLogs::create($payload);

            DB::connection('mysql')->commit();
        } catch (\Exception $e) {
            DB::connection('mysql')->rollback();
        }
    }
}
