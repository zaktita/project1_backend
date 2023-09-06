<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Orders;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(){
        $notifications = Orders::join('notifications', 'orders.order_id', '=', 'notifications.order_id')
        ->get();
        return response()->json(['notifications' => $notifications]);
    }

    public function destroy($id){
        Notification::destroy($id);
        return response()->json('Notification deleted successfully');
    }
    public function destroyALL(){
        Notification::query()->delete();
        return response()->json('Notifications deleted successfully');
    }
}
