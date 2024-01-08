<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = [ 'company_name', 'country_id', 'state_id', 'city', 'user_id', 'title', 'address', 'postcode', 'default_address' ,'theme_id'];

    protected $appends = ["demo_field", "country_name", "state_name", "city_name", "city_id"];

    public function getDemoFieldAttribute()
    {
        return 'demo_field';
    }

    public function getCountryNameAttribute()
    {
        $CountryData_name = '';
        if(!empty($this->country_id)){

            $country = country::find($this->country_id);
            if(!empty($country)) {
                $CountryData_name = $country->name;
            }
        }
        return $CountryData_name;
    }

    public function getStateNameAttribute()
    {
        $StateyData_name = '';
        $Statey = state::find($this->state_id);
        if(!empty($Statey)) {
            $StateyData_name = $Statey->name;
        }
        return $StateyData_name;
    }

    public function getCityNameAttribute()
    {
        $CityData_name = $this->city;		
        $City_data = City::find($this->city);
        if(!empty($City_data)) {
            $CityData_name = $City_data->name;
        }
		
        return $CityData_name;
    }

    public function getCityIdAttribute()
    {
        return $this->city;
    }

    public function CountryData()
    {
        return $this->hasOne(country::class, 'id', 'country_id')->select('name');
    }

    public function StateData()
    {
        return $this->hasOne(state::class, 'id', 'state_id')->select('name');
    }

    public function UserData()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
