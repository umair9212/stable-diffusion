<?php

namespace App\Services;

use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Http;

class Text2ImageService
{
    public static function Text2ImageService($input)
    {
        $apiUrl = 'https://stablediffusionapi.com/api/v4/dreambooth';
        $payload = [
            "key" => "8jHXY1PYm8tynfIEwpNDbUcbkeZiwFKcLP7VenoPyytbCBRuOaydh9JW8K7w",
            "model_id" => "juggernaut-xl",
            "prompt" => $input->prompt,
            "negative_prompt" => "easynegative, bad-hands-5, deformed, UnrealisticDream, BadDream, head, neck, human",
            "width" => "1024",
            "height" => "1024",
            "samples" => "1",
            "num_inference_steps" => "41",
            "safety_checker" => "no",
            "enhance_prompt" => "no",
            "seed" => null,
            "guidance_scale" => "7.5",
            "use_karras_sigmas" => "yes",
            "algorithm_type" => "dpmsolver+++",
            "scheduler" => "DPMSolverMultistepScheduler",
            "lora_model" => "lego_lora_xl",
            "lora_strength" => "0.60",
            "free_u" => null,
            "multi_lingual" => null,
            "track_id" => null,
            "webhook" => null
        ];
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $response = Http::withHeaders($headers)->post($apiUrl, $payload);

        if ($response->successful()) {
            if ($response['status'] == 'success') {
                return response()->json([
                    'success' => true,
                    'status' => $response['status'],
                    'output' => $response['output'],
                ], 200);
            } elseif ($response['status']  == 'processing') {
                return response()->json([
                    'success' => true,
                    'status' => $response['status'],
                    'output' => $response['future_links'],
                ], 200);
            }
        } else {
            return response()->json(
                [
                    'success' => false,
                    'status' => 'error',
                    'message' => 'bad request',
                ],
                400
            );
        }
    }
}
