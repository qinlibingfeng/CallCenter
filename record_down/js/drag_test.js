var Drag = {
    target: null,
    init: function(handle, dragMain) {
        Drag.target = handle;
        Drag.target.style.cursor = "move";
        handle.root = dragMain;
        handle.onmousedown = Drag.start;

    },
    start: function() {
        var handle = Drag.target;
        Drag.mouseX = window.event.clientX;
        Drag.mouseY = window.event.clientY;
        Drag.flag = true;
        document.onmousemove = Drag.move;
        document.onmouseup = Drag.end;

    },
    move: function() {
        if (Drag.flag) {
            if (window.event.button == 1 | window.event.which == 1) {
                var handle = Drag.target;
                var mouseX = window.event.clientX;
                var mouseY = window.event.clientY;
                var top = parseInt(handle.root.style.top);
                var left = parseInt(handle.root.style.left);
                var cl = left + (mouseX - Drag.mouseX);
                var ct = top + (mouseY - Drag.mouseY);
                handle.root.style.left = cl + "px";
                handle.root.style.top = ct + "px";
                Drag.mouseX = mouseX;
                Drag.mouseY = mouseY;

            }

        }

    },
    end: function() {
        document.onmousemove = null;
        document.onmouseup = null;
        Drag.flag = false;

    }

};
Drag.init(pw.$("_DialogTitle_"+this.ID),pw.$("_Dialog_"+this.ID));