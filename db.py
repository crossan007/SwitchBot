import os
import sys
from sqlalchemy import Column, ForeignKey, Integer, String
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from sqlalchemy.ext.declarative import declarative_base
#from sqlalchemy_declarative import Address, Base, Person


Base = declarative_base()
 
class ControlObjectTemplate(Base):
    __tablename__ = 'ControlObjectTemplates'
    # Here we define columns for the control object templates
    # each plugin will validate its existance in this table upon load
    id = Column(Integer, primary_key=True)
    name = Column(String(250), nullable=False)

class ControlObjectPropertyTemplate(Base):
    __tablename__ = 'ControlObjectPropertyTemplates'
    # Here we define columns for the control object templates
    # each plugin will validate its existance in this table upon load
    id = Column(Integer, primary_key=True)
    name = Column(String(250), nullable=False)
    ControlObjectTemplate
    
class SwitchBotSettingsRegistry(Base):
    __tablename__ = 'SwitchBotInstanceSettings'
    id=Column(Integer,primary_key=True)
    settingName=Column(String(250),nullable=False)
    settingValue=Column(String(250),nullable=False)
 
 
# Create an engine that stores data in the local directory's
# sqlalchemy_example.db file.
engine = create_engine('sqlite:///SwitchBot.db')
 
# Create all tables in the engine. This is equivalent to "Create Table"
# statements in raw SQL.
Base.metadata.create_all(engine)