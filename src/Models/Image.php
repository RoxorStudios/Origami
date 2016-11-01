<?php

namespace Origami\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Storage;

use Carbon\Carbon;

use Intervention\Image\ImageManagerStatic as Intervention;
use Intervention\Image\Image as InterventionImage;

use Origami\Models\Field;

class Image extends Model
{
	
    public $table = 'origami_images';

    protected $fillable = [
        'path', 'filename', 'thumbnail',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        
    ];

    /**
     * Cleanup task
     * Unlink every image that is older than 1 hour
     */
    public static function cleanup()
    {
        foreach(Image::whereNull('data_id')->where('updated_at','<',Carbon::now()->subHours(1))->get() as $image) {
            $image->unlink();
        }
    }

    /**
     * Save image for field
     */
    public static function saveImageForField(Field $field, UploadedFile $tmp_image)
    {
        $path = origami_content().'/'.str_random(30).'.png';
        $tmp = Intervention::make($tmp_image->getRealPath())->encode('png');
        Storage::disk(origami_disk())->put($path, $tmp->__toString(), 'public');
        $image = $field->images()->create(['path' => $path, 'filename' => $tmp_image->getClientOriginalName()]);

        $image->makeThumbnail();
        $image->resizeOriginal();
    
        return $image;
    }

    /**
     * Make thumbnail
     */
    public function makeThumbnail()
    {
        if(empty($this->field->options['image']['thumbnail'])) return;
        $this->update(['thumbnail'=>true]);

        $crop = !empty($this->field->options['image']['thumbnail']['crop']) ? true : false;
        $image = $this->resizeIntervention($this->field->options['image']['thumbnail']['width'], $this->field->options['image']['thumbnail']['height'],$crop, Intervention::make(Storage::disk(origami_disk())->get($this->path)));
        Storage::disk(origami_disk())->put(origami_thumbnail($this->path), $image->__toString(), 'public');
    }

    /**
     * Resize original
     */
    public function resizeOriginal()
    {
        if(empty($this->field->options['image']['resize'])) return;

        $crop = !empty($this->field->options['image']['resize']['crop']) ? true : false;
        $image = $this->resizeIntervention($this->field->options['image']['resize']['width'], $this->field->options['image']['resize']['height'],$crop, Intervention::make(Storage::disk(origami_disk())->get($this->path)));
        Storage::disk(origami_disk())->put($this->path, $image->__toString(), 'public');
    }

    /**
     * Resize intervention image
     */
    private function resizeIntervention($width, $height, $crop, InterventionImage $image)
    {
        if(!$crop)
            return $image->resize($width, $height, function ($constraint) { $constraint->aspectRatio(); })->encode('png');
        return $image->fit($width, $height)->encode('png');
    }

    /**
     * Make identifier
     */
    protected function makeIdentifier()
    {
        $identifier = str_slug($this->name);
        $i=1;
        if(DB::table($this->table)->where('id','!=',$this->id)->where('identifier',$identifier)->count()) {
            do {
                $identifier = str_slug($this->name).'-'.$i;
                $i++;
            }
            while (DB::table($this->table)->where('identifier',$identifier)->count());
        }
        return $identifier;
    }

    /**
     * Belongs to a field
     */
    public function field()
    {
        return $this->belongsTo('Origami\Models\Field');
    }

    /**
     * Save an image
     */
    public function save(array $options = array())
    {
        if(!$this->uid) $this->uid = origami_uid($this->table);
        if(!$this->position) $this->position = Image::max('position') + 1;
        parent::save($options);
        return $this;
    }

    

    /**
     * Delete an image
     */
    public function unlink()
    {
        Storage::disk(origami_disk())->delete($this->path);
        Storage::disk(origami_disk())->delete(origami_thumbnail($this->path));
        parent::delete();
    }



}
