/* Main js file */
$(document).ready(function(){
	$("#subscriptionEmailLabel").inFieldLabels();
	/*
	$('#randomDealSlider').jbhSlider({
		transition: {
			type: 'horizontal-left',
			duration: 1000,
			timer: 4000,
			repeat: -1,
            actionStopTimer: false,
            mouseHoverStop: false
		},
		pagination: {
			type: 'numbers'
			//type: false
        },
		css: {
			height:527
		},
        navigation: {
        	active: false
    	}
	});
	*/
	/* count down for the deal date */
	var newYear = new Date(),
		i = 0; 
	newYear = new Date(newYear.getFullYear() + 1, 1 - 1, 1); 
	$('#timer').countdown({until: newYear});
	/* for the very first time the page get loaded the vertical slider should be filled up with some data */
	$('#featuredDealSliderWrapper #featureDealsLoadingIndicator').attr('src', 'http://localhost/99aed.com/public/images/ajax-loader.gif');
	$.ajax({  
		type: "GET",
		url: "http://localhost/99aeddeals/ajaxFunctions.php?action=grabInitialDeals", 
		data: "somedat",
		success: function(response){			
			if (response){
				$('#featuredDealSliderWrapper #featureDealsLoadingIndicator').hide();
				$('#featuredDealSliderWrapper').html(response);
			}
		} 
	});
	
    /* slider for the vertical content */ 
	setInterval(function() {
        i++;
		$("div.featuredDeal:first").animate({'margin-top': '-100px'}, 1500).fadeOut(300, function(){ 
			$(this).remove();
		});
		$.ajax({  
			type: "GET",
			url: "http://localhost/99aeddeals/ajaxFunctions.php?action=grabDeal&initial=" + 5 + "&next=" + i, 
			success: function(response){			
				if (response){
					$('.featuredDeal:last').after(response);
					$.ajax({  
						type: "GET",
						url: "http://localhost/99aeddeals/ajaxFunctions.php?action=grabDealInfo&dealId=" + $('.featuredDeal:nth-child(2)').attr('id'), 
						success: function(response){			
							if (response){
								//$('.featuredDeal:last').after(response);
							}
						} 
					});
				}
			} 
		});
	}, 5000);
});