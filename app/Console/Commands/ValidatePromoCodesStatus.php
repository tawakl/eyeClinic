<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use App\Modules\PromoCodes\Repository\PromoCodeRepository;
use App\Modules\PromoCodes\Repository\UserPromoCodeRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ValidatePromoCodesStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validate:promo-codes-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Promo Codes Status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // Get Expired Promo Codes
            $activeCondition = [
                ['is_active', 1]
            ];
            $activePromoCodes = (new PromoCodeRepository())->getByData($activeCondition);
            foreach ($activePromoCodes as $promoCode) {
                if ($promoCode->to < now()) {
                    (new PromoCodeRepository())->update(
                        $promoCode->id,
                        [
                            'is_active' => 0,
                            'is_on_landing_page' => 0,
                        ]
                    );
//                    Log::channel('slack-info')->info('Promo Code Expired : '.$promoCode->id);
                    continue;
                }
                $userPromoCodeData = [
                    ['promo_code_id', $promoCode->id],
                ];
                $promoCodeUsers = (new UserPromoCodeRepository())->getByData($userPromoCodeData);
                if (count($promoCodeUsers) >= $promoCode->count_for_all_students) {
                    (new PromoCodeRepository())->update(
                        $promoCode->id,
                        [
                            'is_active' => 0,
                            'is_on_landing_page' => 0,
                        ]
                    );
                }
                (new UserPromoCodeRepository())->updateUnCompletedUserPromoCodesStatus();
            }
//            Log::channel('slack-info')->info('Promo Codes Status Checked Successfully');
            return true;
        } catch (\Exception $exception) {
            Log::error('Promo Codes Status Check Failed');
            Log::error($exception->getMessage());
            return false;
        }
    }
}
