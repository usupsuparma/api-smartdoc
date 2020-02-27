<?php namespace App\Modules\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Test\Transformers\TestTransformer;
class TestModel extends Model {
	
	use SoftDeletes;

	public $transformer = TestTransformer::class;
	
    protected $table = 'tests';
    protected $fillable   = [
        'name','email','description'
	];
	
	protected $dates = ['deleted_at'];
}