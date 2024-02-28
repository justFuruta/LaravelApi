<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CompanyResource::collection(Company::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request)
    {
        try {
            $data = $request->validated();

            $logo = $request->file('logo');
            $logoName = uniqid() . '.' . $logo->getClientOriginalExtension();
            $logoPath = $logo->storeAs('logos', $logoName, 'public');

            $company = Company::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'logo' => $logoPath
            ]);

            return response()->json(['message' => 'Компания успешно создана', 'data' => new CompanyResource($company)], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка создания компании: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyStoreRequest $request, Company $company)
    {
        try {
            $data = $request->validated();

            $logo = $request->file('logo');
            $logoName = uniqid() . '.' . $logo->getClientOriginalExtension();
            $logoPath = $logo->storeAs('logos', $logoName, 'public');

            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }

            $company->logo = $logoPath;
            $company->name = $data['name'];
            $company->description = $data['description'];
            $company->save();

            return response()->json(['message' => 'Данные компании успешно обновлены', 'data' => new CompanyResource($company)], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка обновления данных компании: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();
            return response()->json(['message' => 'Компания успешно удалена'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка удаления компании: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function comments(Company $company)
    {
        $comments = $company->comments()->get();
        return response()->json(['data' => $comments]);
    }

    public function grade(Company $company)
    {
        $rating = $company->comments()->avg('rating');
        return response()->json(['data' => $rating]);
    }

    public function rating()
    {
        $rating = Company::query()->withAvg('comments', 'rating')->orderBy('comments_avg_rating', 'desc')->get()->take(10);
        return response()->json(['data' => $rating]);
    }
}
