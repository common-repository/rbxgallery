jQuery(function ()
{
	jQuery('#content form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var message;
			
			if (!jQuery('.message').length)
			{
				jQuery('#demonstrations').after('<div class="message" style="display:none; padding:10px; text-align:center" />');
			}
			
			
			if (jQuery('input[type=file]').val().length)
			{
				jQuery('.message')
					.html('Uploading file&hellip;')
					.css({
						color : '#006100',
						background : '#c6efce',
						border : '2px solid #006100'
					})
					.slideDown();
			}
			
			else
			{
				jQuery('.message')
					.html('Please select an image for uploading.')
					.css({
						color : '#9c0006',
						background : '#ffc7ce',
						border : '2px solid #9c0006'
					})
					.slideDown();
				
				return false;
			}
		},
		complete : function (response)
		{
			var style,
				width,
				html = '';
			
			
			if (!response.success)
			{
				jQuery('.message').slideUp(function ()
				{
					jQuery(this)
						.html('There was a problem with the image you uploaded')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006'
						})
						.slideDown();
				});
			}
			
			else
			{
				html += '<p>Below is the uploaded image and the values that were posted when you submitted the demonstration form.</p>';
				
				
				if (response.postedValues)
				{
					for (title in response.postedValues)
					{
						html += '<strong>' + title + ':</strong> ' + response.postedValues[title] + '<br />';
					}
				}
				
				
				if (response.imageSize)
				{
					width = response.imageSize[0] > 500 ? 500 : response.imageSize[0];
				}
				
				
				if (response.imageSource)
				{
					html += '<img src="' + response.imageSource + '" width="' + width + '" alt="Your uploaded image" />';
				}
				
				
				jQuery('.message').slideUp(function ()
				{
					jQuery(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100'
						})
						.slideDown();
				});
			}
		}
	});
});