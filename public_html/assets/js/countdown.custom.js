function Countdown(options) {
	function getTimestamp() { return Math.floor(Date.now() / 1000); }
	// e.g. if the app is closed and js no longer renders
	var verifierForSkippedSeconds = getTimestamp()
	function countdowner() {
		var offset = getTimestamp() - verifierForSkippedSeconds
		if (offset >= 2) {
			remaining -= offset;
		} else {
			remaining -= 1;
		}

		verifierForSkippedSeconds = getTimestamp()

		var text = '';
		if (remaining < 60) {
			text = remaining;
		} else if (remaining < 60 * 60) {
			text = moment.utc(remaining * 1000).format("m:s");
		} else {
			text = moment.utc(remaining * 1000).format("H:m:s");
		}

		if (remaining == 0) {
			clearInterval(interval);
			setTimeout(countdownCallback, reloadCallbackDelay * 1000);
			text = ''
		}

		var percentage = (duration - remaining) / onePercentOfDuration;
		if (progressBar) {
			progressBar.animate(percentage / 100);
			progressBar.setText(text);
		}

		if (bottomProgress && document.getElementById(bottomProgress)) {
			document.getElementById(bottomProgress).style.width = percentage + '%';
		}
	}

	var progressBar = false;
	var remaining = 0;
	var duration = 0;
	var reloadCallbackDelay = 2;
	var bottomProgress = false;
	var countdownCallback = function() {
		location.reload();
	}

	if (options.countdownCallback) countdownCallback = options.countdownCallback;
	if (options.reloadCallbackDelay) reloadCallbackDelay = options.reloadCallbackDelay;
	if (options.remaining) remaining = options.remaining;
	if (options.duration) duration = options.duration;
	if (options.progressBar) progressBar = options.progressBar;
	if (options.bottomProgress) bottomProgress = options.bottomProgress;
	var onePercentOfDuration = duration / 100.0

	countdowner();
	var interval = setInterval(countdowner, 1000);
}
