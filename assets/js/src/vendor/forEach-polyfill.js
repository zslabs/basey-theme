if (typeof Array.prototype.forEach != 'function') {
	Array.prototype.forEach = function(callback){
		for (var i = 0; i < this.length; i++){
			callback.apply(this, [this[i], i, this]);
		}
	};
}