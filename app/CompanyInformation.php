<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyInformation extends Model
{

    protected $table = 'company_informations';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fillable = ['answer_1', 'answer_2', 'answer_3', 'answer_4', 'answer_5'];

    protected $attributes = [
            'phone_number' => '',
            'voicemail_number' => '',
            'monthly_date' => '',
            'scanning_frequency' => '',
            'answer_1' => '',
            'answer_2' => '',
            'answer_3' => '',
            'answer_4' => '',
            'checklist_access_1' => '',
            'checklist_access_2' => '',
            'checklist_access_3' => '',
            'checklist_access_4' => '',
            'checklist_access_5' => '',
            'checklist_access_6' => '',
            'checklist_access_7' => '',
            'checklist_access_8' => '',
            'checklist_access_9' => '',
            'checklist_access_10' => '',
            'checklist_access_11' => '',
            'notes' => '',
            'telephone_number' => '',
            'phone_script' => '',
            'mailbox_number' => '',
            'frequency' => '',
            'day_of_week' => ''
        ];

    public function company() {
        return $this->belongsTo('App\Company', 'company_id');
    }
    
}
