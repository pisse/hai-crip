

(function(global) {
    /*

     * id : dom
     * cover : 图片地址
     * coverType : image or color
     * width : 要使用的图像的宽度
     * heighr : 要使用的图像的高度
     * drawPercentCallback :  刮奖完毕会掉
     * sWidth : 被剪切图像的宽度。
     * sHeight : 被剪切图像的高度。
     * */
    function Lottery(id, cover, coverType, width, height, drawPercentCallback, sWidth, sHeight,drawEnd) {
        this.conId = id;
        this.conNode = document.getElementById(this.conId);
        this.cover = cover;
        this.coverType = coverType;
        this.background = null;
        this.backCtx = null;
        this.mask = null;
        this.maskCtx = null;
        this.lottery = null;
        this.lotteryType = 'image';
        this.width = width || 300;
        this.height = height || 100;
        this.drawEnd = drawEnd || null;
        this.clientRect = null;
        this.drawPercentCallback = drawPercentCallback;
        this.sWidth = sWidth;
        this.sHeight = sHeight;
    }

    Lottery.prototype = {
        createElement: function(tagName, attributes) {
            var ele = document.createElement(tagName);
            for (var key in attributes) {
                ele.setAttribute(key, attributes[key]);
            }
            return ele;
        },
        getTransparentPercent: function(ctx, width, height) {
            var imgData = ctx.getImageData(0, 0, width, height),
                pixles = imgData.data,
                transPixs = [];
            for (var i = 0, j = pixles.length; i < j; i += 4) {
                var a = pixles[i + 3];
                if (a < 128) {
                    transPixs.push(i);
                }
            }
            return (transPixs.length / (pixles.length / 4) * 100).toFixed(2);
        },
        resizeCanvas: function(canvas, width, height) {
            canvas.width = width;
            canvas.height = height;
            canvas.getContext('2d').clearRect(0, 0, width, height);
        },
        clearMask: function() {
//          removeBodyMove();
            this.mask.getContext('2d').clearRect(0, 0, this.width, this.height);
        },
//		drawPoint: function (x, y) {
//	        this.maskCtx.beginPath();
//	        var radgrad = this.maskCtx.createRadialGradient(x, y, 0, x, y, 30);
//	        radgrad.addColorStop(0, 'rgba(0,0,0,0.6)');
//	        radgrad.addColorStop(1, 'rgba(255, 255, 255, 0)');
//	        this.maskCtx.fillStyle = radgrad;
//	        this.maskCtx.arc(x, y, 30, 0, Math.PI * 2, true);
//	        this.maskCtx.fill();
//	        if (this.drawPercentCallback) {
//	            this.drawPercentCallback.call(null, this.getTransparentPercent(this.maskCtx, this.width, this.height));
//	        }
//	        $('body').css('overflow',"hidden");
//			$('#hand').hide();
//	    },
        drawPoint: function(x, y) {
            this.maskCtx.beginPath();
            this.maskCtx.fillStyle = '#fff';
            this.maskCtx.arc(x, y, 28, 0, Math.PI * 2, false);
            this.maskCtx.fill();
            if (!this.conNode.innerHTML.replace(/[\w\W]| /g, '')) {
                //this.background&&this.conNode.appendChild(this.background);
                this.conNode.appendChild(this.mask);
                this.clientRect = this.conNode ? this.conNode.getBoundingClientRect() : null;
            }
//          bodyMove();
        },
        bindEvent: function() {
            var _this = this;
            var device = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
            var clickEvtName = device ? 'touchstart' : 'mousedown';
            var moveEvtName = device ? 'touchmove' : 'mousemove';
            if (!device) {
                var isMouseDown = false;
                document.addEventListener('mouseup', function(e) {
                    isMouseDown = false;
                }, false);
            } else {
                document.addEventListener("touchmove", function(e) {
                    if (isMouseDown) {
                        e.preventDefault();
                    }
                }, false);
                document.addEventListener('touchend', function(e) {
                    isMouseDown = false;
                }, false);
            }
            this.mask.addEventListener(clickEvtName, function(e) {
                isMouseDown = true;
                var docEle = document.documentElement;
                if (!_this.clientRect) {
                    _this.clientRect = {
                        left: 0,
                        top: 0
                    };
                }
                var x = (device ? e.touches[0].clientX : e.clientX) - _this.clientRect.left + docEle.scrollLeft - docEle.clientLeft;
                var y = (device ? e.touches[0].clientY : e.clientY) - _this.clientRect.top + docEle.scrollTop - docEle.clientTop;
                _this.drawPoint(x, y);
            }, false);

            this.mask.addEventListener(moveEvtName, function(e) {
                if (!device && !isMouseDown) {
                    return false;
                }
                var docEle = document.documentElement;
                if (!_this.clientRect) {
                    _this.clientRect = {
                        left: 0,
                        top: 0
                    };
                }
                var x = (device ? e.touches[0].clientX : e.clientX) - _this.clientRect.left + docEle.scrollLeft - docEle.clientLeft;
                var y = (device ? e.touches[0].clientY : e.clientY) - _this.clientRect.top + docEle.scrollTop - docEle.clientTop;
                _this.drawPoint(x, y);
            }, false);

            this.mask.addEventListener('touchend', function(e) {
                if (_this.drawPercentCallback) {
                    _this.drawPercentCallback.call(null, _this.getTransparentPercent(_this.maskCtx, _this.width, _this.height));
                }
            }, false);
        },
        drawLottery: function() {


            this.mask = this.mask || this.createElement('canvas', {
                style: 'position:absolute;left:0;top:0;z-index:300'
            });
            this.maskCtx = this.maskCtx || this.mask.getContext('2d');
            this.drawMask();
            if (this.lottery) {
                this.background = this.background || this.createElement('canvas', {
                    style: 'position:relative;left:0;top:0;z-index:200;'
                });
                this.backCtx = this.backCtx || this.background.getContext('2d');

                var _this = this;
                if (this.lotteryType == 'image') {
                    var image = new Image();
                    image.onload = function() {
                        _this.width = this.width;
                        _this.height = this.height;
                        _this.resizeCanvas(_this.background, this.width, this.height);
                        _this.backCtx.drawImage(this, 0, 0);
                    }
                    image.src = this.lottery;
                } else if (this.lotteryType == 'text') {
                    this.width = this.width;
                    this.height = this.height;
                    this.resizeCanvas(this.background, this.width, this.height);
                    this.backCtx.save();
                    this.backCtx.fillStyle = '#FFF';
                    this.backCtx.fillRect(0, 0, this.width, this.height);
                    this.backCtx.restore();
                    this.backCtx.save();
                    var fontSize = 30;
                    this.backCtx.font = 'Bold ' + fontSize + 'px Arial';
                    this.backCtx.textAlign = 'center';
                    this.backCtx.fillStyle = '#F60';
                    this.backCtx.fillText(this.lottery, this.width / 2, this.height / 2 + fontSize / 2);
                    this.backCtx.restore();
                }
            }


            if (!this.conNode.innerHTML.replace(/[\w\W]| /g, '')) {
                this.conNode.appendChild(this.mask);
                this.clientRect = this.conNode ? this.conNode.getBoundingClientRect() : null;
                this.bindEvent();
            }
        },
        drawMask: function() {
            this.resizeCanvas(this.mask, this.width, this.height);
            if (this.coverType == 'color') {
                this.maskCtx.fillStyle = this.cover;
                this.maskCtx.fillRect(0, 0, this.width, this.height);
                this.maskCtx.globalCompositeOperation = 'destination-out';
                _this.drawEnd && _this.drawEnd();
            } else if (this.coverType == 'image') {
                var image = new Image(),
                    _this = this;
                image.onload = function() {
                    _this.maskCtx.drawImage(this, 0, 0, _this.sWidth, _this.sHeight, 0, 0, _this.width, _this.height);
                    _this.maskCtx.globalCompositeOperation = 'destination-out';
                    _this.drawEnd && _this.drawEnd();
                }
                image.crossOrigin = 'Anonymous';
                image.src = this.cover;
            }
        },
        init: function(lottery, lotteryType) { //'开奖结果内容'
            this.lottery = lottery;
            this.lotteryType = lotteryType || 'image';
            this.drawLottery();
        }
    }


    // for node environment
    if (typeof module === "object" && module && typeof module.exports === "object") {
        module.exports = Lottery;
    } else if (typeof define === "function" && (define.amd || define.cmd)) {
        // for cmd, amd, commonjs
        define("Lottery", [], function() {
            return Lottery;
        });
    } else {
        // for global environment. like window
        global.Lottery = Lottery;
    }

})(this);