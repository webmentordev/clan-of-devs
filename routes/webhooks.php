<?php
use App\Events\MessageCreated;
use App\Models\Message;
use App\Models\WebHook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("/{webhook}", function(Request $request, $webhook){
    try{
        $webhook = WebHook::where('webhook', $webhook)->first();
        if(!$webhook){
            return response()->json([
                "message" => "Webhook not found!",
            ], 404);
        }
        $request->validate([
            'content' => ['required', '4500']
        ]);

        $message = Message::create([
            'message' => $request->content,
            'channel_id' => $webhook->channel_id,
            'webhook_id' => $webhook,
            'user_id' => null,
        ]);
        broadcast(new MessageCreated($message));
        return response()->json([
            "message" => "Webhook call success!",
        ], 200);
    }catch(\Throwable $e){
        return response()->json([
            "message" => "Something went wrong!",
        ], 500);
    }
});