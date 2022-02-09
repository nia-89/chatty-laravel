<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class ChatsTest extends TestCase
{

    use WithFaker, RefreshDatabase;
    
    public function test_a_user_can_upload_a_file() {

        $this->withoutExceptionHandling();

        Storage::fake('local');

        $file = UploadedFile::fake()->create('chat.txt');

        $attributes = [
            'filename' => now()->format('Y-m-d_His').'_'.'chat.txt',
            'file' => $file
        ];

        $this->post('/', $attributes)->assertRedirect('/chats');

        $this->assertDatabaseHas('chats', ['filename' => $attributes['filename']]);

        Storage::disk('local')->assertExists('uploads/'.$attributes['filename']);
    }
}
