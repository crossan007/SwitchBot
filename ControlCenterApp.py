from flask import Flask, render_template, json, request
from flask_mysqldb import MySQL
from werkzeug import generate_password_hash, check_password_hash
import imp
import os

app = Flask(__name__)



ControlObjects = [
{
'ControlObjectName' : 'ProjectorControls',
'ControlObjectClassGUID' : 'f6dfc3cb-1456-4e1c-8766-97c9a3275741',
'ControlObjectProperties' : [
{
'ControlObjectPropertyName' : 'Input',
'ControlObjectPropertyType' : 'MultiChoice',
'ControlObjectPropertyOptions' : {'VGA','DVD','Blank'}
},
{
'ControlObjectPropertyName' : 'Freeze',
'ControlObjectPropertyType' : 'MultiChoice',
'ControlObjectPropertyOptions' : {'Frozen','Unfrozen'}
}
]},
{
'ControlObjectName' : 'Front of House Controls',
'ControlObjectClassGUID' : 'asdfasdfasdf',
'ControlObjectProperties' : [
{
'ControlObjectPropertyName' : 'Stage Lights',
'ControlObjectPropertyType' : 'MultiChoice',
'ControlObjectPropertyOptions' : {'On','Off'}
},
{
'ControlObjectPropertyName' : 'Booth Lights',
'ControlObjectPropertyType' : 'MultiChoice',
'ControlObjectPropertyOptions' : {'On','Off'}
},
{
'ControlObjectPropertyName' : 'House Lights',
'ControlObjectPropertyType' : 'MultiChoice',
'ControlObjectPropertyOptions' : {'On','Off'}
}
]},
{
'ControlObjectName' : 'Speaker Controls',
'ControlObjectClassGUID' : 'asdfasdfasdf',
'ControlObjectProperties' : [
{
'ControlObjectPropertyName' : 'Mains',
'ControlObjectPropertyType' : 'MultiChoice',
'ControlObjectPropertyOptions' : {'On','Off'}
},
{
'ControlObjectPropertyName' : 'Nursery Speakers',
'ControlObjectPropertyType' : 'MultiChoice',
'ControlObjectPropertyOptions' : {'On','Off'}
},
{
'ControlObjectPropertyName' : 'Stage Monitors',
'ControlObjectPropertyType' : 'MultiChoice',
'ControlObjectPropertyOptions' : {'On','Off'}
}
]},
{
'ControlObjectName' : 'Climage',
'ControlObjectClassGUID' : 'asdfasdfasdf',
'ControlObjectProperties' : [
{
'ControlObjectPropertyName' : 'Fans',
'ControlObjectPropertyType' : 'MultiChoice',
'ControlObjectPropertyOptions' : {'On','Off'}
}
]}
]

#Load plugins per https://lkubuntu.wordpress.com/2012/10/02/writing-a-python-plugin-api/
PluginFolder = "./plugins"
MainModule = "__init__"

def getPlugins():
    plugins = []
    possibleplugins = os.listdir(PluginFolder)
    for i in possibleplugins:
        location = os.path.join(PluginFolder, i)
        if not os.path.isdir(location) or not MainModule + ".py" in os.listdir(location):
            continue
        info = imp.find_module(MainModule, [location])
        plugins.append({"name": i, "info": info})
    return plugins

def loadPlugin(plugin):
    return imp.load_module(MainModule, *plugin["info"])



@app.route('/')
def main():
    return render_template('index.html',ControlObjects=ControlObjects)

@app.route('/api/presets/setactivepreset',methods=['POST'])
def setActivePreset():
    presetName = request.form['presetName']
    return "Activating Preset: %s " % presetName
    
@app.route('/api/presets/',methods=['GET','PUT','DELETE'])
def preset():
    return "Preset"
    
@app.route('/api/setcontrol',methods=['POST'])
def control():
    controlObject = request.form['controlObject']
    controlProperties = request.form['controlProperties']
    return "Setting Control: %s " % controlObject
    

    
for i in getPlugins():
    print("Loading plugin " + i["name"])
    plugin = loadPlugin(i)
    plugin.run()
    print(plugin.getControlObjectClassGUID())
    print(plugin.getControlObjectProperties())
    
if __name__ == "__main__":
    app.run(host='0.0.0.0',port=5002)
    
