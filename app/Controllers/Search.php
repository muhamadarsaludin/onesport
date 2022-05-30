<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\GroupsUsersModel;
use App\Models\BannersModel;
use App\Models\SportsModel;
use App\Models\VenueModel;
use App\Models\VenueLevelsModel;
use App\Models\ArenaModel;
use App\Models\ArenaImagesModel;
use App\Models\ArenaFacilitiesModel;
use App\Models\FieldsModel;
use App\Models\FieldImagesModel;
use App\Models\FacilitiesModel;
use App\Models\DayModel;
use App\Models\ScheduleModel;
use App\Models\ScheduleDetailModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\RepaymentModel;
use App\Models\RatingModel;


class Search extends BaseController
{
    protected $usersModel;
    protected $groupsUsersModel;
    protected $bannersModel;
    protected $sportsModel;
    protected $venueModel;
    protected $venueLevelsModel;
    protected $arenaModel;
    protected $arenaImagesModel;
    protected $arenaFacilitiesModel;
    protected $fieldsModel;
    protected $fieldImagesModel;
    protected $facilitiesModel;
    protected $dayModel;
    protected $scheduleModel;
    protected $scheduleDetailModel;
    protected $transactionModel;
    protected $transactionDetailModel;
    protected $repaymentModel;
    protected $ratingModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
        $this->groupsUsersModel = new GroupsUsersModel();
        $this->bannersModel = new BannersModel();
        $this->sportsModel = new SportsModel();
        $this->venueModel = new VenueModel();
        $this->venueLevelsModel = new VenueLevelsModel();
        $this->arenaModel = new ArenaModel();
        $this->arenaImagesModel = new ArenaImagesModel();
        $this->arenaFacilitiesModel = new ArenaFacilitiesModel();
        $this->fieldsModel = new FieldsModel();
        $this->fieldImagesModel = new FieldImagesModel();
        $this->facilitiesModel = new FacilitiesModel();
        $this->dayModel = new DayModel();
        $this->scheduleModel = new ScheduleModel();
        $this->scheduleDetailModel = new ScheduleDetailModel();
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
        $this->repaymentModel = new RepaymentModel();
        $this->ratingModel = new RatingModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'venues' => $this->venueModel->getVenueSuggest($keyword)->getResultArray(),
            'fields' => $this->fieldsModel->getFieldSuggest($keyword)->getResultArray(),
        ];    
        // dd($data);
        return json_encode($data);
    }

    // public function result()
    // {
    //     $keyword = $this->request->getVar('keyword');
    //     $data = [
    //         'title' => 'RH Wedding Planner',
    //         'vendors' => $this->vendorModel->getVendorsByKeyword($keyword),
    //         'products' => $this->productModel->getProductsByKeyword($keyword),
    //         'keyword' => $keyword
    //     ];

    //     // dd($data);
    //     return view('main/search_result', $data);
    // }

}
