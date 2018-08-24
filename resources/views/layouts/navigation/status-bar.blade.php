<nav class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <div class="nav navbar-form navbar-left">
            <portal-target name="status-bar-left"></portal-target>
        </div>

        <div class="nav navbar-form navbar-right">
            <a class="btn btn-info" data-toggle="tooltip"
               data-title="Hilfe"
               data-placement="top"
               @click="openHelpModal"
            >
                <span class="fa fa-question-circle"></span>&nbsp;
            </a>

            <modal namespace="help" ref="helpModal"></modal>
        </div>

        <div class="nav navbar-form navbar-right">
            <portal-target name="status-bar-right"></portal-target>
        </div>
    </div>
</nav>