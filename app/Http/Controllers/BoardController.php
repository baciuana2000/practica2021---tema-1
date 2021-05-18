<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;


/**
 * Class BoardController
 *
 * @package App\Http\Controllers
 */
class BoardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function boards()
    {
        /** @var User $user */
        $user = Auth::user();

        $boards = Board::with(['user', 'boardUsers']);

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                //Suntem in tabele de boards in continuare
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        //Suntem in tabela de board_users
                        $query->where('user_id', $user->id);
                    });
            });
        }

        $boards = $boards->paginate(10);

        return view(
            'boards.index',
            [
                'boards' => $boards
            ]
        );
    }

   /**
     * @param  Request  $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function updateBoard(Request $request, $id): JsonResponse
    {
  

        /** @var User $user */
            $user = Auth::user();
        if($user->id==$request->IdUserCreator || $user->role === User::ROLE_ADMIN)
        {

                $board = Board::find($id);
               
                
                $error = '';
                $success = '';
            
                if ($board) 
                {
                    $name=$request->name;
                    $board->name =$name;
                
                    $board->save();
                    $board->refresh();

                    $success = 'Board saved';
                }
                else {
                    $error = 'Board not found!';
                }
                return response()->json(['error' => $error, 'success' => $success, 'board' => $board]);
        }
     }

/**
     * @param  Request  $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function deleteBoard(Request $request, $id): JsonResponse
    {
        $board = Board::find($id);

        $error = '';
        $success = '';

        if ($board) {
            $board->delete();

            $success = 'Board deleted';
        } else {
            $error = 'Board not found!';
        }

        return response()->json(['error' => $error, 'success' => $success]);
    }

/**
     * @param  Request  $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function deleteTaskAjax(Request $request, $id): JsonResponse
    {
        $task = Task::find($id);

        $error = '';
        $success = '';

        if ($task) {
            $task->delete();

            $success = 'Task deleted';
        } else {
            $error = 'Task not found!';
        }

        return response()->json(['error' => $error, 'success' => $success]);
    }
/**
     * @param  Request  $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function updateTaskAjax(Request $request, $id): JsonResponse
    {
        $task = Task::find($id);

        $error = '';
        $success = '';

        if ($task) {
            $name = $request->get('name');
            $description = $request->get('description');
            $assignment = $request->get('assignment');
            $status = $request->get('status');
            $created_at = $request->get('created_at');
          

            if ($name) {
                $task->name = $name;
                $task->description=$description;
                $task->assignment=$assignment;
                $task->status=$status;
                $task->created_at=$created_at;
             
                $task->save();
                $task->refresh();

                $success = 'task saved';
            } else {
                $error = 'name selected is not valid!';
            }
        } else {
            $error = 'task not found!';
        }

        return response()->json(['error' => $error, 'success' => $success, 'task' => $task]);
    }



    /**
     * @param $id
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function board($id)
    {
        /** @var User $user */
        $user = Auth::user();

        $boards = Board::query();
        $tasks = Task::query();

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    
                    });
            });
        }

        $board = clone $boards;
        $users = User::query();
        $users =  $users->select('id', 'name')->get();
        
        $board = $board->where('id', $id)->first();

        $boards = $boards->select('id', 'name')->get();
      $task=clone $tasks;
        $tasks = $tasks->select('id','board_id', 'name','description','assignment','status','created_at')->where('board_id',$id)->get();
     $task = $task->select('name')->where('assignment',$id)->get();
        if (!$board) {
            return redirect()->route('boards.all');
        }

        return view(
            'boards.view',
            [
                'board' => $board, 
                'boards' => $boards,
                'tasks' => $tasks,
                'users' => $users,
                'task' => $task
            ]
        );
    }


    
}
