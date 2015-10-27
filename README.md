# SwitchBot
SwitchBot is an open source project designed to manage media and power control devices such as web power switches, projectors, mixing boards. 
##Concepts
###Framework 
SwitchBot is a framework that leverages Python, Flask, MySQL, jQuery, and BootStrap to deliver a truly Web 2.0 experience.  
###Scalable
SwitchBot uses a modular approach for defining each control device.  Each device is represented as a dynamically loaded Python plugin.  The list of installed plugins dictates what devices may be controlled from the web application.  Each plugin validates that it has been properly registered in the contorol database
###Presets
What control system would be complete without presets?  User-programmable presets allow you to easily change your entire collection of control devices with a single click!