<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Videos;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class VideoControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations, TestSaves;

    private $video;

    protected function setUp(): void
    {
        parent::setUp();
        $this->video = Videos::create(
            [
                'title' => 'title',
                'description' => 'description',
                'year_launched'=>2019,
                'opened'=>true,
                'rating'=>Videos::RATING_LIST[0],
                'duration'=>120
            ]);
        $this->video->refresh();
    }

    public function testIndex()
    {
        $response = $this->get(route('videos.index'));
        $response->assertStatus(200)->assertJson([$this->video->toArray()]);
    }

    public function testInvalidationDataRequired()
    {
        $data = [
            'title' => '',
            'description' => '',
            'year_launched'=>'',
            'rating'=>'',
            'duration'=>''
        ];
        $this->assertInvalidationInStoreAction($data,'validation.required');
        $this->assertInvalidationInUpdateAction($data, 'validation.required');
    }

    protected function routeStore()
    {
        return route('videos.store');
    }

    protected function routeUpdate()
    {
        return route('videos.update',['video'=> $this->video->id]);
    }

    protected function model()
    {
        return Videos::class;
    }
}
