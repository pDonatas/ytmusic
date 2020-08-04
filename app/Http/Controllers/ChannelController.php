<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return new Response(json_encode(Channel::all()));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->request->get('name');
        if($name == null) return response(['error' => 'Name is not set'], 500);
        $dj = Auth::id(); // Assume that user who creates a channel is DJ
        $channel = new Channel();
        $channel->dj = $dj;
        $channel->name = $name;
        $channel->save();
        return new Response(json_encode(['success' => 'Channel created successfully']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new Response(Channel::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $channel = Channel::findOrFail($id);
        $channel->setName($request->request->get('name'));
        $channel->setDj(Auth::id());
        $channel->save();
        return new Response(json_encode(['success' => 'Channel updated successfully']));
    }

    public function updateYoutube(Request $request, $id)
    {
        $channel = Channel::findOrFail($id);
        $youtube = $request->request->get('youtubeId');
        $time = $request->request->get('time');
        if($youtube == null)
            return response(['error' => 'Youtube id is not set'], 500);
        elseif($time == null)
            return response(['error' => 'Time is not set'], 500);
        $channel->youtubeId = $youtube;
        $channel->time = $time;
        $channel->save();
        return new Response(json_encode(['success' => 'Channel updated successfully']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Channel::findOrFail($id)->delete();
        return new Response(json_encode(['success' => 'Channel successfully deleted']));
    }
}
