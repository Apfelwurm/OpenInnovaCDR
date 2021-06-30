
Getting Started
==================================================
We are glad that you want to try or use the OpenInnovaCDR.

OpenInnovaCDR self hosted production - Installation
------------------------------------

The recommended way to install it with the Makefile, you can however do everything by hand or with your own docker-compose file.



    .. warning::

        Currently OpenInnovaCDR is not publicly available on Docker Hub, therfore you should use the installation variant using make or build the manager docker image yourself with our sourcecode.

Prerequisites
..............

- Docker v17
- Docker-compose v1.18
- for the make installation way you need ``make`` installed


Installation with the Makefile
...............................
This method uses docker-compose to build the OpenInnovaCDR image from the source code instead of pulling them from docker hub. You need the whole source code for running this! If you plan to participate in the development of OpenInnovaCDR, its worth checking out the Makefile and the Developer getting started guide. There are many useful commands implemented that you can use to make your life easier (see developer documentation).

todo


Custom Timezone
..................................................................
todo




Caveats
^^^^^^^^^^^^^^^^^^^^^^^^^

todo


Installation Page
..................................................................
the last step before you can use the OpenInnovaCDR is the installation page (if you did not used automated seeding), it will pop up after the initial installation.

todo:image

.. image:: ../images/Installation01.png
   :height: 1136px
   :width: 910px
   :scale: 50 %
   :alt: OpenInnovaCDR installation page
   :align: center

You have to fill out all the input fields an finnaly click on Confirm to get redirected to your working OpenInnovaCDR admin dashboard.
If you want to know all about the settings, take a look into the settings documentation part. But you can follow step to step and we tell you if you have to take care of something in the settings part.

