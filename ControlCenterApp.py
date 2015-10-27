from flask import Flask, render_template, json, request
from flask_mysqldb import MySQL
from werkzeug import generate_password_hash, check_password_hash
import imp
import os


#mysql = MySQL()
app = Flask(__name__)

# MySQL configurations
#app.config['MYSQL_DATABASE_USER'] = ''
#app.config['MYSQL_DATABASE_PASSWORD'] = ''
#app.config['MYSQL_DATABASE_DB'] = ''
#app.config['MYSQL_DATABASE_HOST'] = ''
#mysql.init_app(app)


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
]}]


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
    
