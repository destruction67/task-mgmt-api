<?php

use App\Models\task\Task;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable(true);
            $table->string('description')->nullable(true);
            $table->date('due_date')->nullable(true);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // <editor-fold defaultState="collapsed" desc="RECORD INSERTION">
        $tasks = [
            [
                'title' => 'Buy groceries',
                'description' => 'Go to the market',
                'due_date' => '2023-06-19',
                'status' => 1,
            ],
            [
                'title' => 'Wake up',
                'description' => 'Hey you you\'re finally awake',
                'due_date' => '2023-06-22',
                'status' => 0,
            ],
            [
                'title' => 'Feed the ducks',
                'description' => 'Peace was never an option',
                'due_date' => '2023-07-02',
                'status' => 0,
            ],

            [
                'title' => 'Watch a movie',
                'description' => 'Play spiderman',
                'due_date' => '2023-07-02',
                'status' => 1,
            ],

            [
                'title' => 'Watch Anime',
                'description' => 'Yamete kudasai',
                'due_date' => '2023-07-02',
                'status' => 0,
            ],

            [
                'title' => 'Play the guitar',
                'description' => 'Guitar is located in the room',
                'due_date' => '2023-07-02',
                'status' => 1,
            ],
            [
                'title' => 'Hello World',
                'description' => 'Hello world nice to meet you',
                'due_date' => '2023-07-02',
                'status' => 0,
            ],
            [
                'title' => 'Exam on thursday',
                'description' => 'I need to review',
                'due_date' => '2023-07-02',
                'status' => 0,
            ],

            [
                'title' => 'Exam on thursday',
                'description' => 'I need to review',
                'due_date' => '2023-07-02',
                'status' => 0,
            ],
            [
                'title' => 'Exam on thursday',
                'description' => 'I need to review',
                'due_date' => '2023-07-02',
                'status' => 0,
            ],
            [
                'title' => 'Exam on thursday',
                'description' => 'I need to review',
                'due_date' => '2023-07-02',
                'status' => 0,
            ],
            [
                'title' => 'Play music',
                'description' => 'use spotify account',
                'due_date' => '2023-07-02',
                'status' => 0,
            ],

            [
                'title' => 'Buy some ice cream',
                'description' => 'I need to buy ice cream at the nearest store',
                'due_date' => '2023-07-02',
                'status' => 0,
            ],

            [
                'title' => 'Watch Cinema',
                'description' => 'The flash is premiering this month',
                'due_date' => '2023-07-02',
                'status' => 0,
            ],

        ];

        foreach ($tasks as $task) {
            $newTask = new Task($task);
            $newTask->title = $task['title'];
            $newTask->description = $task['description'];
            $newTask->due_date = $task['due_date'];
            $newTask->status = $task['status'];
            $newTask->save();
        }
        // </editor-fold>

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
