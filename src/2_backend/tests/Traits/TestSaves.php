<?php
namespace Tests\Traits;

trait TestSaves
{
    protected function assertStore($sendData, $testDatabase, $testJsonData= null)
    {
        /** @var TestResponse $response**/
        $response = $this->json('POST', $this->routeStore(), $sendData);

        if($response->status() != 201){
            throw new \Exception("Response status must be 201, given"+ $response->status() +": \n"+ $response->content());
        }
        $this->assertInDatabase($response, $testDatabase);
        $this->assertInJson($response, $testDatabase, $testJsonData);
    }

    protected function assertUpdate($sendData, $testDatabase, $testJsonData= null)
    {
        /** @var TestResponse $response**/
        $response = $this->json('PUT', $this->routeUpdate(), $sendData);

        if($response->status() != 200){
            throw new \Exception("Response status must be 200, given"+ $response->status() +": \n"+ $response->content());
        }
        $this->assertInDatabase($response, $testDatabase);
        $this->assertInJson($response, $testDatabase, $testJsonData);
    }

    private function assertInDatabase($response, $testDatabase){
        $model = $this->model();
        $table = (new $model)->getTable();
        $this->assertDataBaseHas($table, $testDatabase + ['id' => $response->json('id')]);
    }

    private function assertInJson($response, $testDatabase, $testJsonData){
        $testResponse = $testDatabase ?? $testJsonData;
        $response->assertJsonFragment($testResponse + ['id' => $response->json('id')]);
    }

}
