<?php
/* @var $this App\View\AppView */
/* @var $logs DatabaseLogger\Model\Entity\Logging */

$global_class = [
    'default' => ['debug'],
    'success' => [],
    'warning' => ['warning'],
    'danger' => ['error', 'critical', 'alert', 'emergency'],
    'info' => ['notice', 'info']
];
function FindClass($globalClass, $class){
    foreach ($globalClass as $key => $value) {
	if(in_array(strtolower($class), $value)){
	    return $key;
	}
    }
    return '';
}
?>

<?php $this->start("scriptBottom"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
<script>
    (function($){
	$(document).ready(function(){
	    $("#logs .trHead").click(function(){
		var body = $(this).next();
		if(body.length > 0){
		    if(body.css('display') === 'none'){
			$(this).addClass("current");
			body.show();
		    } else {
			$(this).removeClass("current");
			body.hide();
		    }
		}
	    });
	});
    })(jQuery);
</script>
<script>
    angular.module("app",[]).controller('ctrl',['$scope',function($scope){
	
	$scope.classes = {
	    'default'	: ['debug'],
	    'success'	: [],
	    'warning'	: ['warning'],
	    'danger'	: ['error', 'critical', 'alert', 'emergency'],
	    'info'	: ['notice', 'info']
	};
	
	$scope.getTrClass = function(type){
	    for(var i=0; i<$scope.classes.length;i++){
		if(jQuery.inArray(type.toUpperCase(),$scope.classes[i]) > -1){
		    return 
		}
	    }
	}
	
	$scope.logs = [];
	
	$scope.toggleLog = function(log){
	    if(log.opened === undefined || log.opened === false) 
		log.opened = true;
	    else
		log.opened = false;
	};
	
	var loadLogs = function(){
	    var url = "<?= $this->Url->build([ 'plugin' => 'DatabaseLogger', 'controller'=>'Logs', 'action'=>'index' ]) ?>"
	    jQuery.ajax({
		url : url,
		method : 'post',
		data: '',
		dataType:'json',
		success: function(datas){
		    $scope.logs = datas;
		    $scope.$apply();
		},
		error:function(code,error){
		    console.log(code,error);
		}
	    });
	};
	
	loadLogs();
	
    }]);
</script>
<?php $this->end(); ?>


<style>
    .trHead.current { font-weight: bold; border-top-color: #555 !important; }
    .trBody td { border-bottom-color: #555 !important; }
    dl.dl-horizontal dt { width : 100px; text-align: left; }
    dl.dl-horizontal dd { margin-left:120px; }
</style>

<div ng-app="app" ng-controller="ctrl">
    
        
    <pre>{{logs[0] | json}}</pre>
    <table class="table table-condensed table-bordered" id="logs">
	<tr>
	    <th style="width:150px;">Date</th>
	    <th style="width:100px;">Level</th>
	    <th>Message</th>
	    <th style="width: 100px;">IP</th>
	    <th >Hostname</th>
	</tr>
	
	<tr ng-class="{  }" ng-repeat-start="log in logs" ng-click="toggleLog(log)">
	    <td>{{ log.created }}</td>
	    <td>{{ log.type }}</td>
	    <td>{{ log.created }}</td>
	    <td></td>
	    <td></td>
	</tr>
	
	<tr ng-repeat-end>
	</tr>
	
	
	
	<?php foreach ($logs as $log): ?>
	    <?php
		$messageArray = explode("\n", str_replace("\r\n", "\n", $log->message));
		$message = $messageArray[0];
		$trClass=  FindClass($global_class, $log->type);
	    ?>
	<tr class="<?= $trClass ?> trHead" style="cursor:pointer;">
		<td><?= $this->Time->format($log->created, "yyyy-MM-dd HH:mm:ss", NULL, "Europe/Paris") ?></td>
		<td><?= $log->type ?></td>
		<td><div style="overflow: auto; width:100%;"><?= $message ?></div></td>
		<td><?= $log->ip ?></td>
		<td><?= $log->hostname ?></td>
	    </tr>
	    <tr class="<?= $trClass ?> trBody" style="display:none;">
		<td colspan="5">
		    <dl class="dl-horizontal">
			<dt>URI</dt>
			<dd><?= $log->uri ?></dd>
			<dt>REFER</dt>
			<dd><?= $log->refer ?></dd>
		    </dl>
		    <?php if(count($messageArray) > 1): ?>
		    <pre><?= $log->message ?></pre>
		    <?php endif; ?>
		</td>
	    </tr>
	<?php endforeach; ?>
    </table>
</div>