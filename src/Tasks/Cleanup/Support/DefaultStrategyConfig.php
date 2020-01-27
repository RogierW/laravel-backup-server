<?php

namespace Spatie\BackupServer\Tasks\Cleanup\Support;

use Spatie\BackupServer\Models\Source;

class DefaultStrategyConfig
{
    private Source $source;

    public int $keepAllBackupsForDays;
    public int $keepDailyBackupsForDays;
    public int $keepWeeklyBackupsForWeeks;
    public int $keepMonthlyBackupsForMonths;
    public int $keepYearlyBackupsForYears;
    public int $deleteOldestBackupsWhenUsingMoreMegabytesThan;

    public function __construct(Source $source)
    {
        $this->source = $source;

        $this->keepAllBackupsForDays = $this->getConfigValue('keep_all_backups_for_days');
        $this->keepDailyBackupsForDays = $this->getConfigValue('keep_daily_backups_for_days');
        $this->keepWeeklyBackupsForWeeks = $this->getConfigValue('keep_weekly_backups_for_weeks');
        $this->keepMonthlyBackupsForMonths = $this->getConfigValue('keep_monthly_backups_for_months');
        $this->keepYearlyBackupsForYears = $this->getConfigValue('keep_yearly_backups_for_years');
        $this->deleteOldestBackupsWhenUsingMoreMegabytesThan = $this->getConfigValue('delete_oldest_backups_when_using_more_megabytes_than');
    }

    private function getConfigValue(string $attribute): int
    {
        return $this->source->$attribute ?? $this->source->destination->$attribute;
    }
}
