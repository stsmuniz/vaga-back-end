<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Requests\StoreClient;
use App\User;
use Illuminate\Http\Request;

class UserClientController extends BaseController
{
    protected $user;
    protected $client;

    public function __construct(Client $client)
    {
        $this->middleware(function($request, $next) {
            $this->user = \Auth::user();
            $this->client = $this->user->client();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse($this->client->get()->toArray(), 'Clients retrieved Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClient $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {
        $clientData = $request->all();
        $clientData['user_id'] = $this->user->id;

        try {
            $client = $this->client->create($clientData);
        } catch (\Exception $e) {
            return $this->sendError('Error on creating user', [$e->getMessage()]);
        }

        return $this->sendResponse($client->toArray(), 'Client stored Successfully', 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return $this->sendResponse($client->toArray(), 'Client retrieved Successfully');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $clientData = $request->all();

        try {
            $client->save($clientData);
        } catch (\Exception $e) {
            return $this->sendError('Error on updating user', [$e->getMessage()]);
        }

        return $this->sendResponse($client->toArray(), 'Client updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        try {
            $client->delete();
        } catch (\Exception $e) {
            return $this->sendError('Error on deleting user', [$e->getMessage()]);
        }

        return $this->sendResponse($client->toArray(), 'Client deleted Successfully', 202);
    }
}
