
Rickshaw.namespace('Rickshaw.Fixtures.RandomData');

Rickshaw.Fixtures.RandomData = function(timeInterval) {

	var addData;
	timeInterval = timeInterval || 1;

	var lastRandomValue = 200;

	var timeBase = Math.floor(new Date().getTime() / 1000);

	this.addData = function(data,value) {

		var randomValue = Math.random() * 100 + 15 + lastRandomValue;
		var index = data[0].length;

		var counter = 1;

		data.forEach( function(series) {
			
			series.push( { x: (index * timeInterval) + timeBase, y: value } );
		} );

		lastRandomValue = randomValue * 0.85;
	};

	this.removeData = function(data) {
		data.forEach( function(series) {
			series.shift();
		} );
		timeBase += timeInterval;
	};
};

