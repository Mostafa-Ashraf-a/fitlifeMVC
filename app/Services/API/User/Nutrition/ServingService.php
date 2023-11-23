<?php


namespace App\Services\API\User\Nutrition;


class ServingService
{
    const UNDER_IMPLEMENTATION = 3;
    const In_PROGRESS_PLAN     = 2;

    public function update($request, $serving, $user)
    {
        $serving = $serving->where('id', $serving->id)
            ->where('user_id', $user->id)
            ->where('status', self::UNDER_IMPLEMENTATION)
            ->where('plan_status', self::In_PROGRESS_PLAN)
            ->first();
        if(!$serving)
        {
            return $response = [
                'message'   => "You don't have a permission to access this resource!",
                'status'    => 403,
                'data'      => null,
                'isSuccess' => false
            ];
        }
        $updateServing = $serving->update([
            'starches'     => $request->starches,
            'fruits'       => $request->fruits,
            'vegetables'   => $request->vegetables,
            'meats'        => $request->meats,
            'dairy'        => $request->dairy,
            'oils'         => $request->oils,
        ]);
        if($updateServing)
        {
            return $response = [
                'message'   => __('api.Updated Successfully!'),
                'status'    => 200,
                'data'      => null,
                'isSuccess' => true
            ];
        }
        return $response = [
            'message'   => "Oops! something went wrong",
            'status'    => 500,
            'data'      => null,
            'isSuccess' => false
        ];
    }
}
