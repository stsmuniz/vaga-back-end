<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Dependent;
use App\Http\Requests\storeDependent;
use App\User;
use Illuminate\Http\Request;

class UserClientDependentController extends BaseController
{
    private $user;
    private $client;
    private $dependent;

    /**
     * UserClientDependentController constructor.
     * @param Client $client
     * @param Dependent $dependent
     */
    public function __construct(Client $client, Dependent $dependent)
    {
        $this->middleware(function($request, $next) {
            $this->user = \Auth::user();
            $this->client = $this->user->client();
            $this->dependent = $this->client->dependent();
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
        return $this->sendResponse($this->dependent->all()->toArray(), 'Clients retrieved Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Client $client
     * @param StoreDependent $request
     * @return \Illuminate\Http\Response
     */
    public function store(Client $client, StoreDependent $request)
    {
        $clientData = $request->all();

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
     * @param Client $client
     * @param Dependent $dependent
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client, Dependent $dependent)
    {
        return $this->sendResponse($dependent->toArray(), 'Client retrieved Successfully');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Dependent $dependent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client, Dependent $dependent)
    {
        $clientData = $request->all();

        try {
            $dependent->save($clientData);
        } catch (\Exception $e) {
            return $this->sendError('Error on updating user', [$e->getMessage()]);
        }

        return $this->sendResponse($dependent->toArray(), 'Client updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Dependent $dependent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dependent $dependent)
    {
        try {
            $dependent->delete();
        } catch (\Exception $e) {
            return $this->sendError('Error on deleting user', [$e->getMessage()]);
        }

        return $this->sendResponse($dependent->toArray(), 'Client deleted Successfully', 202);
    }
}
