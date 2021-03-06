<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('welcome')->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'card_id' => 'required|unique:clients,card_id|max:11',
        ]);

        Client::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'card_id' => $request->input('card_id'),
        ]);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client, Address $address, $id)
    {
        $data = $client::where('id', $id)->get();
        $addresses = $address::where('client_id', $id)->get();
        return view('show')->with('data', $data)->with('addresses', $addresses);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, $id)
    {
        $data = $client::where('id', $id)->get();
        return view('edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'card_id' => 'required|unique:clients,card_id|max:11',
        ]);

        $client->update([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'card_id' => $request->input('card_id'),
            'updated_at' => now(),
        ]);

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, Address $address)
    {
        $client->delete();
        $address->where('client_id', $client->id)->delete();

        return redirect('/');
    }
}
