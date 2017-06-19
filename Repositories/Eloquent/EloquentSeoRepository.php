<?php namespace Modules\Bcseo\Repositories\Eloquent;

use Modules\Bcseo\Repositories\SeoRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Events\SettingWasCreated;
use Modules\Setting\Events\SettingWasUpdated;
use Modules\Setting\Repositories\SettingRepository;

class EloquentSeoRepository extends EloquentBaseRepository implements SeoRepository
{
    public function createOrUpdate($settings){
        $this->removeTokenKey($settings);

        foreach ($settings as $settingName => $settingValues) {
            if ($setting = $this->findByName($settingName)) {
                $this->updateSetting($setting, $settingValues);
                continue;
            }
            $this->createForName($settingName, $settingValues);
        }
    }

    /**
     * Remove the token from the input array
     * @param $settings
     */
    private function removeTokenKey(&$settings)
    {
        unset($settings['_token']);
    }

    /**
     * Find a setting by its name
     * @param $settingName
     * @return mixed
     */
    public function findByName($settingName)
    {
        return Setting::where('name', $settingName)->first();
    }

    /**
     * Return all modules that have settings
     * with its settings
     * @param  array|string $modules
     * @return array
     */
    public function moduleSettings($modules)
    {
        // TODO: Implement moduleSettings() method.
    }

    /**
     * Return the saved module settings
     * @param $module
     * @return mixed
     */
    public function savedModuleSettings($module)
    {
        // TODO: Implement savedModuleSettings() method.
    }

    /**
     * Find settings by module name
     * @param  string $module
     * @return mixed
     */
    public function findByModule($module)
    {
        // TODO: Implement findByModule() method.
    }

    /**
     * Find the given setting name for the given module
     * @param  string $settingName
     * @return mixed
     */
    public function get($settingName)
    {
        // TODO: Implement get() method.
    }

    /**
     * Return the translatable module settings
     * @param $module
     * @return array
     */
    public function translatableModuleSettings($module)
    {
        // TODO: Implement translatableModuleSettings() method.
    }

    /**
     * Return the non translatable module settings
     * @param $module
     * @return array
     */
    public function plainModuleSettings($module)
    {
        // TODO: Implement plainModuleSettings() method.
    }

    private function updateSetting($setting, $settingValues)
    {
        $name = $setting->name;
        $oldValues = $setting->plainValue;
        $setting->plainValue = $this->getSettingPlainValue($settingValues);
        event(new SettingWasUpdated($name, true, $settingValues, $oldValues));

        return $setting->save();
    }

    private function getSettingPlainValue($settingValues)
    {
        if (is_array($settingValues)) {
            return json_encode($settingValues);
        }

        return $settingValues;
    }

    private function createForName($settingName, $settingValues)
    {
        $setting = new Setting();
        $setting->name = $settingName;

        $setting->isTranslatable = false;
        $setting->plainValue = $this->getSettingPlainValue($settingValues);
        event(new SettingWasCreated($settingName, false, $settingValues));

        return $setting->save();
    }
}
