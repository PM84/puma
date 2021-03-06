'use strict';

const videoElement = document.querySelector('video');
const audioInputSelect = document.querySelector('select#audioSource');
const audioOutputSelect = document.querySelector('select#audioOutput');
const videoSelect = document.querySelector('select#videoSource');
const selectors = [audioInputSelect, audioOutputSelect, videoSelect];

audioOutputSelect.disabled = !('sinkId' in HTMLMediaElement.prototype);
var video = document.getElementById('my-preview');
var recorder;

function gotDevices(deviceInfos) {
	// Handles being called several times to update labels. Preserve values.
	const values = selectors.map(select => select.value);
	selectors.forEach(select => {
		while (select.firstChild) {
			select.removeChild(select.firstChild);
		}
	});
	for (let i = 0; i !== deviceInfos.length; ++i) {
		const deviceInfo = deviceInfos[i];
		const option = document.createElement('option');
		option.value = deviceInfo.deviceId;
		if (deviceInfo.kind === 'audioinput') {
			option.text = deviceInfo.label || `microphone ${audioInputSelect.length + 1}`;
			audioInputSelect.appendChild(option);
		} else if (deviceInfo.kind === 'audiooutput') {
			option.text = deviceInfo.label || `speaker ${audioOutputSelect.length + 1}`;
			audioOutputSelect.appendChild(option);
		} else if (deviceInfo.kind === 'videoinput') {
			option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
			videoSelect.appendChild(option);
		} else {
			console.log('Some other kind of source/device: ', deviceInfo);
		}
	}
	selectors.forEach((select, selectorIndex) => {
		if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
			select.value = values[selectorIndex];
		}
	});
}

navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);

// Attach audio output device to video element using device/sink ID.
function attachSinkId(element, sinkId) {
	if (typeof element.sinkId !== 'undefined') {
		element.setSinkId(sinkId)
			.then(() => {
			console.log(`Success, audio output device attached: ${sinkId}`);
		})
			.catch(error => {
			let errorMessage = error;
			if (error.name === 'SecurityError') {
				errorMessage = `You need to use HTTPS for selecting audio output device: ${error}`;
			}
			console.error(errorMessage);
			// Jump back to first output device in the list as it's the default.
			audioOutputSelect.selectedIndex = 0;
		});
	} else {
		console.warn('Browser does not support output device selection.');
	}
}

function changeAudioDestination() {
	const audioDestination = audioOutputSelect.value;
	attachSinkId(videoElement, audioDestination);
}

function gotStream(stream) {
	window.stream = stream; // make stream available to console
	videoElement.srcObject = stream;
	// Refresh button list in case labels have become available
	return navigator.mediaDevices.enumerateDevices();
}

function handleError(error) {
	console.log('navigator.getUserMedia error: ', error);
}

function start() {
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	const audioSource = audioInputSelect.value;
	const videoSource = videoSelect.value;
	const constraints = {
		audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
		video: {deviceId: videoSource ? {exact: videoSource} : undefined}
	};
	navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
}

audioInputSelect.onchange = start;
audioOutputSelect.onchange = changeAudioDestination;
videoSelect.onchange = start;
start();



document.getElementById('btn-start-recording').addEventListener("click", function(){
	// Disable start recording button
	this.disabled = true;

	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	const audioSource = audioInputSelect.value;
	const videoSource = videoSelect.value;
	const constraints = {
		audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
		video: {deviceId: videoSource ? {exact: videoSource} : undefined}
	};

	// Request access to the media devices
	navigator.mediaDevices.getUserMedia(constraints).then(
		function(stream) {
			// Display a live preview on the video element of the page
			setSrcObject(stream, video);
			navigator.mediaDevices.enumerateDevices();
			// Start to display the preview on the video element
			// and mute the video to disable the echo issue !
			video.play();
			video.muted = true;

			// Initialize the recorder
			recorder = new RecordRTCPromisesHandler(stream, {
				// 				mimeType: 'video/webm;codecs=h264',
				// 				mimeType: 'video/mp4',
				mimeType: 'video/webm',
				// 				bitsPerSecond: 128000
				bitsPerSecond: videoBPS
			});

			// Start recording the video
			recorder.startRecording().then(function() {
// 				alert("Aufnahme gestartet!");
				console.info('Recording video ...');
			}).catch(function(error) {
				console.error('Cannot start video recording: ', error);
			});

			// release stream on stopRecording
			recorder.stream = stream;

			// Enable stop recording button
			document.getElementById('btn-stop-recording').disabled = false;
		}).catch(handleError);

}, false);

document.getElementById('btn-stop-recording').addEventListener("click", function(){
	this.disabled = true;

	recorder.stopRecording().then(function() {
		console.info('stopRecording success');

		// Retrieve recorded video as blob and display in the preview element
		var videoBlob = recorder.getBlob();
		video.src = URL.createObjectURL(videoBlob);
		var url = URL.createObjectURL(videoBlob);
		// 			video.play();

		// Unmute video on preview
		video.muted = false;

		// Stop the device streaming
		recorder.stream.stop();

		// Enable record button again !
		document.getElementById('btn-start-recording').disabled = false;

		var d = new Date();
		var n = d.getFullYear()+"_"+d.getMonth()+"_"+d.getDay()+"____"+d.getHours()+"_"+d.getMinutes()+"_"+d.getSeconds();

		var formData = new FormData();
		formData.append('file', videoBlob);
		formData.append("VideoToken", VideoToken);
		formData.append("uniqid", guid());
		formData.append("fileName",VideoToken+".webm");
		var fileNameTemp;
		// Execute the ajax request, in this case we have a very simple PHP script
		// that accepts and save the uploaded "video" file
		xhr('insert_video.php', formData, function (fName) {
			console.log("Video succesfully uploaded !" + fName);
			// 			write_json_filelist(fName);
			// 			fileNameTemp=fName;
			location.reload();
		});


		// Helper function to send 
		function xhr(url, data, callback) {
			var request = new XMLHttpRequest();
			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					callback(location.href + request.responseText);
				}
			};
			request.open('POST', url);
			request.send(data);
		}

	}).catch(function(error) {
		console.error('stopRecording failure', error);
	});
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);

}, false);

function guid() {
	return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
		s4() + '-' + s4() + s4() + s4();
}
function s4() {
	return Math.floor((1 + Math.random()) * 0x10000)
		.toString(16)
		.substring(1);
}



function handleError(error) {
	console.log('navigator.getUserMedia error: ', error);
	alert(error);
}








/* 
// Store a reference of the preview video element and a global reference to the recorder instance
var video = document.getElementById('my-preview');
// 			var videoHeight = 1280;  Wird im Hauptfile durch PHP gesetzt.
// 			var videoWidth = 720;    Wird im Hauptfile durch PHP gesetzt.
// 			var videoBPS = 1024000;   Wird im Hauptfile durch PHP gesetzt.


var recorder;
navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);


const audioSource = audioInputSelect.value;
const videoSource = videoSelect.value;

function start(){
	navigator.mediaDevices.getUserMedia({
		audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
		video: {deviceId: videoSource ? {exact: videoSource} : undefined,
				width: {max: videoWidth},    //new syntax
				height: {max: videoHeight}   //new syntax
			   },
	}).then(
		function(stream) {
			// Display a live preview on the video element of the page
			setSrcObject(stream, video);
			navigator.mediaDevices.enumerateDevices();
			video.srcObject = stream;
			// Start to display the preview on the video element
			// and mute the video to disable the echo issue !
			video.play();
			video.muted = true;
		});
}
// When the user clicks on start video recording
document.getElementById('btn-start-recording').addEventListener("click", function(){
	// Disable start recording button
	this.disabled = true;


	// Request access to the media devices
	navigator.mediaDevices.getUserMedia({
		// 		audio:true, video:{video: {width: 640}}
		audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
		video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		//		width: {exact: videoWidth}

		// 			   },
	}).then(
		function(stream) {
			// Display a live preview on the video element of the page
			setSrcObject(stream, video);
			navigator.mediaDevices.enumerateDevices();
			// Start to display the preview on the video element
			// and mute the video to disable the echo issue !
			video.play();
			video.muted = true;

			// Initialize the recorder
			recorder = new RecordRTCPromisesHandler(stream, {
				// 				mimeType: 'video/webm;codecs=h264',
				// 				mimeType: 'video/mp4',
				mimeType: 'video/webm',
				// 				bitsPerSecond: 128000
				bitsPerSecond: videoBPS
			});

			// Start recording the video
			recorder.startRecording().then(function() {
				console.info('Recording video ...');
			}).catch(function(error) {
				console.error('Cannot start video recording: ', error);
			});

			// release stream on stopRecording
			recorder.stream = stream;

			// Enable stop recording button
			document.getElementById('btn-stop-recording').disabled = false;
		}).catch(handleError);

}, false);
// 	 	audioInputSelect.onchange = start;
// 	 	audioOutputSelect.onchange = changeAudioDestination;
// 	 	videoSelect.onchange = start;

// When the user clicks on Stop video recording
document.getElementById('btn-stop-recording').addEventListener("click", function(){
	this.disabled = true;

	recorder.stopRecording().then(function() {
		console.info('stopRecording success');

		// Retrieve recorded video as blob and display in the preview element
		var videoBlob = recorder.getBlob();
		video.src = URL.createObjectURL(videoBlob);
		var url = URL.createObjectURL(videoBlob);
		// 			video.play();

		// Unmute video on preview
		video.muted = false;

		// Stop the device streaming
		recorder.stream.stop();

		// Enable record button again !
		document.getElementById('btn-start-recording').disabled = false;

		var d = new Date();
		var n = d.getFullYear()+"_"+d.getMonth()+"_"+d.getDay()+"____"+d.getHours()+"_"+d.getMinutes()+"_"+d.getSeconds();

		var formData = new FormData();
		formData.append('file', videoBlob);
		formData.append("VideoToken", VideoToken);
		formData.append("uniqid", guid());
		formData.append("fileName",VideoToken+".webm");
		var fileNameTemp;
		// Execute the ajax request, in this case we have a very simple PHP script
		// that accepts and save the uploaded "video" file
		xhr('insert_video.php', formData, function (fName) {
			console.log("Video succesfully uploaded !" + fName);
			// 			write_json_filelist(fName);
			// 			fileNameTemp=fName;
			//location.reload();
		});


		// Helper function to send 
		function xhr(url, data, callback) {
			var request = new XMLHttpRequest();
			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					callback(location.href + request.responseText);
				}
			};
			request.open('POST', url);
			request.send(data);
		}

	}).catch(function(error) {
		console.error('stopRecording failure', error);
	});
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);

}, false);

audioInputSelect.onchange = start;
videoSelect.onchange = start;

start();

function guid() {
	return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
		s4() + '-' + s4() + s4() + s4();
}
function s4() {
	return Math.floor((1 + Math.random()) * 0x10000)
		.toString(16)
		.substring(1);
}



function handleError(error) {
	console.log('navigator.getUserMedia error: ', error);
	alert(error);
} */