import socket

def run(self):
    print("Hello from the projector plugin!")
    self.GetProjector.visible='yes'
    
def getName():
    return "Projector"
    
    
def getControlObjectClassGUID():
    return "f6dfc3cb-1456-4e1c-8766-97c9a3275741"

def getControlObjectProperties():
    return "Some video inputs"

def getInstantiationRequirements():
    reqs=[{"name" : "IP Address","type":"text"}]
    return reqs    
    
    
def GetProjector(IP,command):
    """
    Handle sending requests to the projector
    Accepts the projector's IP, and the raw command
    returns the raw value from the projectors
    FCC Proj: "192.168.10.55"
    GetProjector("192.168.10.55","QPW")
    """
    sock=socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.connect((IP,20108))
    cmd = str.encode(chr(2)+command+chr(3))
    sock.send(cmd)
    print ("Command sent: ",cmd)
    response = bytearray()
    while True:
        data = sock.recv(1)
        if data != str.encode(chr(2)) and data != str.encode(chr(3)): response+=data
        if data == str.encode(chr(3)): break
    sock.close()
    return response

def GetProjectorStatus(IP):
    """
    Gets the projectors status.
    returns true for on, false for off
    GetProjectorStatus("192.168.10.55")
    """
    return int(GetProjector(IP,"QPW"))

def GetProjectorBulbHours(IP):
    """
    Gets the projectors reported bulb hours
    returns an integer
    GetProjectorBulbHours("192.168.10.55")
    """
    return int(GetProjector(IP,"Q$L"))
    
def GetProjectoInputSource(IP):
    """
    Gets the projectors reported bulb hours
    returns an integer
    GetProjectoInputSource("192.168.10.55")
    """
    return GetProjector(IP,"QIN")