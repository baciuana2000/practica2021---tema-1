<?php

namespace App\Http\Controllers;
use App\Models\Board;
use App\Models\BoardUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController
 * 
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    { 
        /** @var User $user */
        $user = Auth::user();
        $boards = Board::query();
        //$board->user->id === $user->id ||

        if ( $user->role === User::ROLE_ADMIN) {
      
       $boards = $boards->select('id')->get();
        }
        else{
            $boards = $boards->select('id')->where('user_id', $user->id)->get();
        }
           
        $tasks = Task::query();
        $tasks = $tasks->select('id','status')->get();

        return view('dashboard.index',
        [
            'boards' => $boards,
            'tasks' => $tasks,
        ]
        
    
    );
    }
}
