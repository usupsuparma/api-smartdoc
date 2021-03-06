<?php namespace App\Modules\Log\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\Log\Transformers\Logransformer;

class LogModel extends Model 
{
	public $transformer = Logransformer::class;
	
    protected $table = 'logs';
    protected $fillable   = [
        'user_id', 'model', 'type', 'reference_id', 'activity', 'visitor'
	];
	
}