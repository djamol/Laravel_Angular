<?php

namespace App\Http\Controllers;

use App\Models\Ball;
use App\Models\Bucket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BucketController extends Controller
{
    public function index(Request $request){

        $ballQuantities = $request->except('user_token');
        $balls = Ball::get();
        $buckets = Bucket::get();

        $ballSizes = [];
        foreach ($balls as $ball) {
            $ballSizes[$ball->name] = $ball->volume;
        }

        $selectedBuckets = [];
        $remainingSpace = [];

        foreach ($buckets as $bucket) {
            $selectedBuckets[$bucket->name] = [
                'total_volume' => $bucket->volume,
                'filled_volume' => 0,
                'balls' => []
            ];
            $remainingSpace[$bucket->name] = $bucket->volume;
        }
        $buckets = $buckets->map(function ($bucket) { return (object) $bucket->toArray(); })->toArray();
        usort($buckets, function ($a, $b) {
            return $a->volume - $b->volume;
        });

        $unplacedBalls = [];

        foreach ($ballQuantities as $ballName => $quantity) {
            $ballSize = $ballSizes[$ballName];

            foreach ($buckets as $bucket) {
                if ($quantity <= 0) {
                    break;
                }

                $availableSpace = $remainingSpace[$bucket->name];
                $ballsToFit = floor($availableSpace / $ballSize);

                if ($ballsToFit > 0) {
                    $ballsToPlace = min($ballsToFit, $quantity);

                    $selectedBuckets[$bucket->name]['filled_volume'] += $ballSize * $ballsToPlace;
                    $remainingSpace[$bucket->name] -= $ballSize * $ballsToPlace;

                    $selectedBuckets[$bucket->name]['balls'][] = [
                        'name' => $ballName,
                        'quantity' => $ballsToPlace
                    ];

                    $quantity -= $ballsToPlace;
                }
            }

            if ($quantity > 0) {
                $unplacedBalls[] = [
                    'name' => $ballName,
                    'quantity' => $quantity
                ];
            }
        }

        $extraBalls = $unplacedBalls;
        foreach ($buckets as $bucket) {
            if (count($extraBalls) === 0) {
                break;
            }

            foreach ($extraBalls as $key => $ball) {
                $ballSize = $ballSizes[$ball['name']];
                $availableSpace = $remainingSpace[$bucket->name];
                $ballsToFit = floor($availableSpace / $ballSize);

                if ($ballsToFit > 0) {
                    $ballsToPlace = min($ballsToFit, $ball['quantity']);

                    $selectedBuckets[$bucket->name]['filled_volume'] += $ballSize * $ballsToPlace;
                    $remainingSpace[$bucket->name] -= $ballSize * $ballsToPlace;

                    $selectedBuckets[$bucket->name]['balls'][] = [
                        'name' => $ball['name'],
                        'quantity' => $ballsToPlace
                    ];

                    $extraBalls[$key]['quantity'] -= $ballsToPlace;

                    if ($extraBalls[$key]['quantity'] === 0) {
                        unset($extraBalls[$key]);
                    }
                }
            }
        }

        $selectedBuckets = array_filter($selectedBuckets, function ($bucket) {
            return $bucket['filled_volume'] > 0;
        });

        return response()->json([
            'selected_buckets' => $selectedBuckets,
            'extra_balls' => $extraBalls,
        ]);
    }





    public static function saveBall(Request $request){
        $rules = [
            'ball_name' => 'required|max:45',
            'ball_vol' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
        ];

        $messages = [
            'ball_name.required' => 'The name field is required',
            'ball_vol.required' => 'The Volume field is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessage = $errors->first();
            return response()->json(['error'=>$errorMessage,'all_errors'=>$errors], 500);

        }
        $ball = new Ball();
        $ball->name=$request->ball_name;
        $ball->volume=$request->ball_vol;
        $ball->save();
        return response()->json(['success'=>1,'message'=>'Successfully Save  Name:'.$request->ball_name], 200);
    }

    public static function getBalls(Request $request){
        return Ball::get();
    }

    public static function getBuckets(Request $request){
        return Bucket::get();
    }
    public static function deleteBall(Request $request){
        $status = Ball::where('id',$request->id)->forceDelete();
        return $status;
    }


    public static function deleteBucket(Request $request){
        $status = Bucket::where('id',$request->id)->forceDelete();
        return $status;
    }
    public static function saveBucket(Request $request){
        $rules = [
            'bucket_name' => 'required|max:45',
            'bucket_vol' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
        ];

        $messages = [
            'bucket_name.required' => 'The name field is required',
            'bucket_vol.required' => 'The Volume field is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessage = $errors->first();
            return response()->json(['error'=>$errorMessage,'all_errors'=>$errors], 500);

        }
        $bucket = new Bucket();
        $bucket->name=$request->bucket_name;
        $bucket->volume=$request->bucket_vol;
        $bucket->save();
        return response()->json(['success'=>1,'message'=>'Successfully Save  Name:'.$request->bucket_name], 200);
    }

}
