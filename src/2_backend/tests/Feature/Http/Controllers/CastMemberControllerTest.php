<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CastMember;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class CastMemberControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations, TestSaves;

    private $castMember;

    protected function setUp(): void
    {
        parent::setUp();
        $this->castMember = CastMember::create(['name'=>'XPTO', 'type'=>CastMember::TYPE_ACTOR]);
        $this->castMember->refresh();

    }

    public function testIndex()
    {
        $response = $this->get(route('castmembers.index'));

        $response
            ->assertStatus(200)
            ->assertJson([$this->castMember->toArray()]);
    }

    public function testShow()
    {
        $response = $this->get(route('castmembers.show',['castmember'=>$this->castMember->id]));

        $response
            ->assertStatus(200)
            ->assertJson($this->castMember->toArray());
    }

    public function testValidatorDataStore()
    {
        $dataWithoutName = ['name' => ''];
        $this->assertInvalidationInStoreAction($dataWithoutName,'validation.required');

        $dataWithoutValidString = ['name' => str_repeat('a',256)];
        $this->assertInvalidationInStoreAction($dataWithoutValidString,'validation.max.string', ['max'=>255]);
    }

    public function testValidatorDataUpdate()
    {
        $this->assertInvalidationInUpdateAction(['name'=>''],'validation.required');
        $this->assertUpdate(['name' => 'test', 'type'=> CastMember::TYPE_ACTOR],['name' => 'test', 'deleted_at'=> NULL]);
    }

    public function testSotre()
    {
        $this->assertStore(['name'=>'test', 'type'=> CastMember::TYPE_ACTOR],['name'=>'test','type'=> CastMember::TYPE_ACTOR]);
    }

    public function testDelete()
    {
        $response = $this->json('DELETE', route('castmembers.destroy',['castmember'=> $this->castMember->id]),[$this->castMember]);
        $response->assertStatus(204);
    }

    protected function routeStore()
    {
        return route('castmembers.store');
    }

    protected function routeUpdate()
    {
        return route('castmembers.update',['castmember'=> $this->castMember->id]);
    }

    protected function model()
    {
        return CastMember::class;
    }
}
