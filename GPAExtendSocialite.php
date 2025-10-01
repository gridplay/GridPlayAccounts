<?php
namespace GPA;
use SocialiteProviders\Manager\SocialiteWasCalled;
class GPAExtendSocialite {
    public function handle(SocialiteWasCalled $socialiteWasCalled): void {
        $socialiteWasCalled->extendSocialite('gridplayaccounts', GpaProvider::class);
    }
}
