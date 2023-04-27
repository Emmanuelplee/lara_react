<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Repositories\Responses;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UrlController extends Controller
{
    private $response;

    public function __construct(Responses $res)
    {
        $this->response = $res;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return Inertia::render('Dashboard');
        // return Inertia::render('Profile/Edit', [
        //     'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
        //     'status' => session('status'),
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        // $validated = $request->validate([
        //     'url' => [
        //         'required',
        //         'url',
        //         Rule::unique('urls')->where(function ($query) use ($request) {
        //             return $query->where('user_id', $request->user()->id);
        //         })->ignore($request->route('id')),
        //     ],
        // ]);
        // ===== FORMA UNO
        // $validator = Validator::make($request->all(), [
        //         'url' => "required|url|min:5|unique:urls",
        // ],
        //     [
        //         'required' =>'El campo :attribute es requerido',
        //         'url'   => 'El campo :attribute no es una url valida',
        //         'unique' => 'LA url ya existe unique:urls'
        //     ]
        // )->validate();
        // ===== FORMA DOS
        $validator = Validator::make($request->all(), [
                'url' => "required|url",
        ],
            [
                'required' =>'El campo :attribute es requerido',
                'url'   => 'El campo :attribute no es una url valida'
            ]
        )->validate();

        $url = $request->user()->urls()->where('url', $request->url)->first();
        // $url = $request->user()->urls()->firstWhere('url', $request->url);

        if ($url) {
            throw ValidationException::withMessages(['url' => 'La url ya existe ValidationException']);
        }


        // $request->user()->urls()->create($validator);
        $user = auth()->user();
        $request->merge([
            'short_url'=> substr(md5($user->id . $request->url),0 , 5),
            'user_id'=>$user->id]);
        $urlCreate = Url::create($request->all());
        // if ($validator->fails()){return $this->response->errorRes($validator->errors());}
        // $validator = $request->validate([
        //     'url' => 'required|url|min:5',
        // ]);
        // return redirect()->route('dashboard')
        // ->with('message', 'Url creada con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function show(Url $url)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function edit(Url $url)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Url $url)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $url)
    {
        //
    }
}
