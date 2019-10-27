import csv
import sys, os
import logging
import random
from typing import Tuple
sys.path.append(os.path.join(os.getcwd(),'python/'))


from time import sleep
import darknet as dn
import pdb
from threading import Thread



__author__ = 'ING_DS_TECH'
__version__ = "201909"

FORMAT = '%(asctime)-15s %(levelname)s %(message)s'
logging.basicConfig(format=FORMAT, level=logging.DEBUG)
logger = logging.getLogger(__name__)

#input_dir = "/home/wolny/Documents/workspace/Hackathon/2019/main/src/validation"
input_dir = "/home/marek/Pulpit/HACK/test_dataset/"
odp_input="./odp/"
answers_file="main.csv"
net = dn.load_net(b"yolov3.cfg", b"yolov3.weights", 0)
meta = dn.load_meta(b"coco.data")

# net = dn.load_net(b"yolo9000.cfg", b"yolo9000.weights", 0)
# meta = dn.load_meta(b"combine9k.data")


labels_task_1 = ['Bathroom', 'Bathroom cabinet', 'Bathroom sink', 'Bathtub', 'Bed', 'Bed frame',
                 'Bed sheet', 'Bedroom', 'Cabinetry', 'Ceiling', 'Chair', 'Chandelier', 'Chest of drawers',
                 'Coffee table', 'Couch', 'Countertop', 'Cupboard', 'Curtain', 'Dining room', 'Door', 'Drawer',
                 'Facade', 'Fireplace', 'Floor', 'Furniture', 'Grass', 'Hardwood', 'House', 'Kitchen',
                 'Kitchen & dining room table', 'Kitchen stove', 'Living room', 'Mattress', 'Nightstand',
                 'Plumbing fixture', 'Property', 'Real estate', 'Refrigerator', 'Roof', 'room', 'Rural area',
                 'Shower', 'Sink', 'Sky', 'Table', 'Tablecloth', 'Tap', 'Tile', 'Toilet', 'Tree', 'Urban area',
                 'Wall', 'Window']

labels_task2 = ['apartment', 'bathroom', 'bedroom', 'dinning_room', 'house', 'kitchen', 'living_room']

labels_task3_1 = [4, 3, 3, 3, 3]
labels_task3_2 = [3, 4, 4, 3, 3]

#room_items=[]

def task_1(partial_output: dict, file_path: str) -> dict:
    logger.debug("Performing task 1 for file {0}".format(file_path))

    print(partial_output['task2_class'])

    tab = partial_output['task2_class']

    partial_output['task2_class'] = partial_output['task2_class'][0]

    for label in labels_task_1:
        partial_output[label] = 0

    #for label in labels_task_1:

    if('bathroom' in tab):
        for x in ["Sink","Bathroom","Bathroom cabinet","Bathroom sink","Bathtub","Shower","Tap","Toilet","Wall","Furniture","Floor","room","Property","Ceiling","Tile"]:
            partial_output[x] = 1
    
    elif ('bedroom' in tab):
        for x in ["Bed","Bed frame","Bed sheet","Bedroom","Chest of drawers","Mattress","Furniture","Floor","room","Property","Ceiling"]:
            partial_output[x] = 1
    
    elif ('dinning_room' in tab):
        for x in ["Chair","Table","Dining room","Tablecloth","Kitchen & dining room table","Furniture","Floor","room","Property","Ceiling"]:
            partial_output[x] = 1
    
    elif ('house' in tab):
        for x in ["House","Window","Door","Property","Real estate","Tree","Property","Rural area","Urban area","Facade","Grass","Roof","Sky"]:
            partial_output[x] = 1
    
    elif ('kitchen' in tab):
        for x in ["Tile","Chair","Cabinetry","Countertop","Cupboard","Dining room","Drawer","Furniture","Kitchen","Kitchen & dining room table","Kitchen stove","Refrigerator","Sink","Table","Tablecloth","Tap","Furniture","Floor","room","Property","Ceiling"]:
            partial_output[x] = 1
    
    elif ('living_room' in tab):
        for x in ["Tile","Living room","Chair","Cabinetry","Countertop","Cupboard","Dining room","Drawer","Furniture","Kitchen","Kitchen & dining room table","Kitchen stove","Refrigerator","Sink","Table","Tablecloth","Tap","Furniture","Floor","room","Property","Ceiling"]:
            partial_output[x] = 1
    
    logger.debug("Done with Task 1 for file {0}".format(file_path))
    return partial_output


def task_2(file_path: str) -> str:
    room_type=""
    logger.debug("Performing task 2 for file {0}".format(file_path))
    
    room_items=dn.detect(net, meta, file_path.encode())

    if((("chair" in room_items or "table" in room_items) and "sink" in room_items) or 'refrigerator' in room_items or "toaster"  in room_items or 'oven' in room_items or 'microwave' in room_items):
        
        room_type = ["kitchen"]
        

    elif("car" in room_items or "bench" in room_items or "bicycle" in room_items or "motorbike" in room_items or "bus" in room_items or "train" in room_items or "truck" in room_items or "boat" in room_items or "traffic light" in room_items or "bird" in room_items or "kite" in room_items):
        
        room_type = ["house"]
        
    elif("sofa" in room_items or "tvmonitor" in room_items ):
        
        room_type=["living_room"]
        
    elif("chair" in room_items and "diningtable" in room_items):
        
        room_type=["dinning_room"]
        
    elif("bed" in room_items):
        
        room_type = ["bedroom"]
        
    elif("toilet" in room_items or "toothbrush" in room_items) :
        
        room_type=["bathroom"]
        
    elif("chair" in room_items):
        
        room_type = [random.choice(["kitchen", "living_room", "dinning_room"]),"kitchen", "living_room", "dinning_room"]
        
    elif("diningtable" in room_items):
       
        room_type = [random.choice(["kitchen", "living_room", "dinning_room"]),"kitchen", "living_room", "dinning_room"]

    elif("sink" in room_items):

        room_type = [random.choice(["kitchen", "bathroom"]), "kitchen", "bathroom"]
        
    else:
        
        room_type = [random.choice(["house", "house", "house", "house", "kitchen", "living_room", "dinning_room", "bathroom"]),"house","kitchen", "living_room", "dinning_room", "bathroom"]
    
    logger.debug("Done with Task 1 for file {0}".format(file_path))
    return room_type


def task_3(file_path: str) -> Tuple[str, str]:
    logger.debug("Performing task 3 for file {0}".format(file_path))
    #
    #
    #	HERE SHOULD BE A REAL SOLUTION
    #
    #
    logger.debug("Done with Task 1 for file {0}".format(file_path))
    return labels_task3_1[random.randrange(len(labels_task3_1))], labels_task3_2[random.randrange(len(labels_task3_2))]


def main(n: int,s: int):
    output = []
    logger.debug("Sample answers file generator")
    for dirpath, dnames, fnames in os.walk(input_dir):
        for f in fnames[n::s]:
            if f.endswith(".jpg"):
                file_path = os.path.join(dirpath, f)
                output_per_file = {'filename': f,
                                   'task2_class': task_2(file_path),
                                   'tech_cond': task_3(file_path)[0],
                                   'standard': task_3(file_path)[1]
                                   }
                output_per_file = task_1(output_per_file, file_path)
                output.append(output_per_file)
                with open("./odp/"+f[:-3]+"csv", 'w', newline='') as csvfile:
                    writer = csv.DictWriter(csvfile,fieldnames=['filename', 'standard', 'task2_class', 'tech_cond'] + labels_task_1)
                    writer.writerow(output_per_file)
                    
def collect():


    with open(answers_file, 'w', newline='') as csvfile:
        writer = csv.DictWriter(csvfile, fieldnames=['filename', 'standard', 'task2_class', 'tech_cond'] + labels_task_1) #Legenda
        writer.writeheader()
        for dirpath, dnames, fnames in os.walk(odp_input):
            for f in fnames:
                if f.endswith(".csv"):
                    with open(odp_input+f, newline='') as c:
                        reader = csv.DictReader(c, fieldnames=['filename', 'standard', 'task2_class', 'tech_cond'] + labels_task_1)
                        for row in reader:
                            writer.writerow(row)
                        #print(reader)
        


if __name__ == "__main__":
    main(int(sys.argv[1]),int(sys.argv[2]))
    # thread0 = Thread(target = main,args=(0,2))
    # thread1 = Thread(target = main,args=(1,2))
    # thread2 = Thread(target = main,args=(2,4))
    # thread3 = Thread(target = main,args=(3,4))
    # thread0.start()
    # thread1.start()
    # thread2.start()
    # thread3.start()
    # thread0.join()
    # thread1.join()
    # thread2.join()
    # thread3.join()
    collect()
    

