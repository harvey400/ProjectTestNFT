<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class postCommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function postComment()
    {
        $param = [ 
                    "comment_id"=>0,
                    "user_id"=>1,
                    "level"=>1,
                    "name"=>"Harvey",
                    "body"=>"This a comment from test"
        ];
        $response = $this->post('api/postComment',$param);
        $response->assertStatus(200);
    }
}
