if (!Date.now) {
	Date.now = function now() {
		return new Date().getTime();
	};
}

class HolidaySaleCountdown{
	constructor(context, releaseDate, endDate){
		this.releaseTime = releaseDate * 1000;
		this.endTime = endDate * 1000;

		this.context = context;

		this.containers = {
			day: context.querySelector('.day'),
			hour: context.querySelector('.hour'),
			min: context.querySelector('.min'),
			sec: context.querySelector('.sec')
		};

		this.default_text = {
			day: this.containers.day.textContent,
			hour: this.containers.hour.textContent,
			min: this.containers.min.textContent,
			sec: this.containers.sec.textContent
		};
	}

	countdown(){
		const self = this;
		var currentTime = new Date().getTime();
		var startTime = this.releaseTime;
		var stop = false;

		if(currentTime > startTime){
			startTime = this.endTime;

			if(typeof self.endText != 'undefined'){
				this.context.querySelector('strong').textContent = self.endText;
			}
		}

		this.seconds = parseInt((startTime - currentTime) / 1000); // In Seconds

		if(this.seconds < 0){
			this.seconds = 0;
			stop = true
		}

		this.minutes = parseInt(this.seconds / 60);
		this.hours = parseInt(this.minutes / 60);
		this.days = parseInt(this.hours / 24);

		this.seconds = this.seconds - (this.minutes * 60);
		this.minutes = this.minutes - (this.hours * 60);
		this.hours = this.hours - (this.days * 24);

		if(this.days < 10){
			this.days = '0' + this.days;
		}

		if(this.hours < 10){
			this.hours = '0' + this.hours;
		}

		if(this.minutes < 10){
			this.minutes = '0' + this.minutes;
		}

		if(this.seconds < 10){
			this.seconds = '0' + this.seconds;
		}

		this.containers.day.innerHTML = '<i>' + this.days + '</i> ' + this.default_text.day;
		this.containers.hour.innerHTML = '<i>' + this.hours + '</i> ' + this.default_text.hour;
		this.containers.min.innerHTML = '<i>' + this.minutes + '</i> ' + this.default_text.min;
		this.containers.sec.innerHTML = '<i>' + this.seconds + '</i> ' + this.default_text.sec;

		if(!stop){
			setTimeout(function(){
				self.countdown();
			}, 1000);
		}else{
			$('.product_list.grid').remove();
		}
	}

	init(){
		this.countdown();
	}
}

$(function(){
	var countdowns = document.querySelectorAll('.holiday_sale_countdown');

	for(i in countdowns){
		var countdown = countdowns[i];

		if(typeof countdown == 'object'){
			var releaseDate = countdown.getAttribute('data-start_date');
			var endDate = countdown.getAttribute('data-end_date');
			var endText = countdown.getAttribute('data-end_text');

			var c = new HolidaySaleCountdown(countdown, releaseDate, endDate);
				c.endText = endText;
				c.init();
		}
	}

	$('#center_column *').each(function(){
		var t = this;
		var that = $(t);

		t.classList.add('HolidaySaleColors');
	});
});