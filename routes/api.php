<?php

use App\Http\Resources\WorldResource;
use App\Models\Galaxy;
use App\Models\World;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Login
Route::group([
    'prefix' => 'auth',
], function () {

    // Login
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/login/panel', [\App\Http\Controllers\AuthController::class, 'loginAdmin']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
/*

*/
});

Route::group([
    'middleware' => 'auth:sanctum',
], function() {

    // Check Auth
    Route::get('/checkauth', [\App\Http\Controllers\AuthController::class, 'checkAuth']);

    // User Info
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'getUserInfo']);

    Route::get('/user/info', [\App\Http\Controllers\UserController::class, 'getRole']);

    // View routes
    Route::get('/view/npcs', [\App\Http\Controllers\NpcController::class, 'viewNpcs']);
    Route::get('/view/quests', [\App\Http\Controllers\QuestsController::class, 'viewQuests']);
    Route::get('/view/dialogues', [\App\Http\Controllers\DialogueController::class, 'viewDialogues']);
    Route::get('/check/balance', [\App\Http\Controllers\ShopController::class, 'checkBalance']);
    Route::get('/view/products', [\App\Http\Controllers\ShopController::class, 'viewProducts']);
    Route::get('/view/galaxies', [\App\Http\Controllers\GalaxyController::class, 'viewGalaxies']);

    // View with variable
    Route::get('/view/dialogues/{nonPlayableCharacter}', [\App\Http\Controllers\DialogueController::class, 'npcDialogues']);
    Route::get('/view/npc/{character}', [\App\Http\Controllers\DialogueController::class, 'getNpcInfo']);
    Route::get('/view/dialogue/{dialogue}', [\App\Http\Controllers\DialogueController::class, 'viewDialogueDetails']);
    Route::get('/view/galaxy/{galaxy}', [\App\Http\Controllers\GalaxyController::class, 'viewGalaxy']);
    Route::get('/view/world/{world}', [\App\Http\Controllers\WorldController::class, 'viewWorld']);
    Route::get('/view/quests/{quest}', [\App\Http\Controllers\QuestsController::class, 'viewQuest']);
    Route::get('/view/world/user/{world}', [\App\Http\Controllers\WorldController::class, 'viewWorldUser']);
    Route::get('/view/section/{section}', [\App\Http\Controllers\SectionController::class, 'viewSection']);
    Route::get('/view/quest/{section}/{quest}/{world}', [\App\Http\Controllers\QuestsController::class, 'viewQuest']);
    Route::get('/user/current_location', [\App\Http\Controllers\UserInformationController::class, 'getInformation']);
    Route::get('/user/customizations', [\App\Http\Controllers\UserInformationController::class, 'getUserCustomization']);
    Route::get('/user/products', [\App\Http\Controllers\ShopController::class, 'getUserProducts']);
    Route::get('/user/get/products', [\App\Http\Controllers\UserInformationController::class, 'getActiveItems']);

    Route::post('/user/update/customizations', [\App\Http\Controllers\UserInformationController::class, 'updateUserCustomization']);
    Route::post('/user/update/current_location', [\App\Http\Controllers\UserInformationController::class, 'updateInformation']);
    Route::post('/json/update/{world}', [\App\Http\Controllers\WorldController::class, 'storeJSON']);
    Route::post('/add/basic/npc/{world}', [\App\Http\Controllers\WorldController::class, 'createBasicNPC']);
    Route::post('/add/item/{world}', [\App\Http\Controllers\ItemController::class, 'createItem']);
    Route::post('/add/world/{galaxy}', [\App\Http\Controllers\WorldController::class, 'createWorld']);
    Route::post('/add/galaxy', [\App\Http\Controllers\GalaxyController::class, 'addGalaxy']);
    Route::post('/add/npc/{world}', [\App\Http\Controllers\NpcController::class, 'storeQuestNPC']);
    Route::post('/create/quest/{world}/{section}', [\App\Http\Controllers\QuestsController::class, 'createQuest']);
    Route::post('/create/section/{world}', [\App\Http\Controllers\SectionController::class, 'createSection']);
    Route::post('/dialogue/add/chat/{dialogue}', [\App\Http\Controllers\DialogueController::class, 'addChat']);
    Route::post('/balance/add/{user}', [\App\Http\Controllers\ShopController::class, 'giveBalance']);
    Route::post('/purchase/item/{product}', [\App\Http\Controllers\ShopController::class, 'buyItem']);
    Route::post('/add/npc', [\App\Http\Controllers\NpcController::class, 'storeNPC']);
    Route::post('/add/dialogue/{character}', [\App\Http\Controllers\DialogueController::class, 'addDialogue']);
    Route::post('/create/user', [\App\Http\Controllers\UserController::class, 'createUser']);
    Route::post('/set/username', [\App\Http\Controllers\UserController::class, 'setUserName']);
    Route::post('/shop/add/product', [\App\Http\Controllers\ShopController::class, 'addProduct']);
    Route::post('/store/quest/{section}/{quest}/{world}', [\App\Http\Controllers\StepsController::class, 'storeStep']);
    Route::post('/update/avatar', [\App\Http\Controllers\UserInformationController::class, 'updateAvatar']);

    // User progress management

    Route::post('/mark/step/{world}/{section}/{quest}/{step}', [\App\Http\Controllers\ProgressController::class, 'completeStep']);


    // Save Progreso global
    Route::post('/progress/save-global', [\App\Http\Controllers\UserProgressController::class, 'saveGlobalProgress']);

    // Save Progreso por mundo
    Route::post('/progress/save-world/{worldId}', [\App\Http\Controllers\UserProgressController::class, 'saveWorldState']);
    
    // Obtener progreso completo del usuario
    Route::get('/user/progress', [\App\Http\Controllers\UserProgressController::class, 'getUserProgress']);
    
    // Obtener estructura de nodo específico con jerarquía
    Route::get('/user/actions/{idUserAction}/hierarchy', [\App\Http\Controllers\UserProgressController::class, 'getActionHierarchy']);
   
    // JSON World por ID
    Route::get('/world/{worldId}', [\App\Http\Controllers\WorldController::class, 'getWorldById']); 
});
