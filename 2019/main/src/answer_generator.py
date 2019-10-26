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
input_dir = "/home/achillesv/Desktop/HACK/test_dataset/"
odp_input="./odp/"
answers_file="main.csv"
net = dn.load_net(b"yolov3.cfg", b"yolov3.weights", 0)
meta = dn.load_meta(b"coco.data")


labels_task_1 = ['Bathroom', 'Bathroom cabinet', 'Bathroom sink', 'Bathtub', 'Bed', 'Bed frame',
                 'Bed sheet', 'Bedroom', 'Cabinetry', 'Ceiling', 'Chair', 'Chandelier', 'Chest of drawers',
                 'Coffee table', 'Couch', 'Countertop', 'Cupboard', 'Curtain', 'Dining room', 'Door', 'Drawer',
                 'Facade', 'Fireplace', 'Floor', 'Furniture', 'Grass', 'Hardwood', 'House', 'Kitchen',
                 'Kitchen & dining room table', 'Kitchen stove', 'Living room', 'Mattress', 'Nightstand',
                 'Plumbing fixture', 'Property', 'Real estate', 'Refrigerator', 'Roof', 'Room', 'Rural area',
                 'Shower', 'Sink', 'Sky', 'Table', 'Tablecloth', 'Tap', 'Tile', 'Toilet', 'Tree', 'Urban area',
                 'Wall', 'Window']

labels_task2 = ['apartment', 'bathroom', 'bedroom', 'dinning_room', 'house', 'kitchen', 'living_room']

labels_task3_1 = [1, 2, 3, 4]
labels_task3_2 = [1, 2, 3, 4]




def task_1(partial_output: dict, file_path: str) -> dict:
    logger.debug("Performing task 1 for file {0}".format(file_path))

    for label in labels_task_1:
        partial_output[label] = 0
    #file
    #
    #	HERE SHOULD BE A REAL SOLUTION
    #
    #

    print(dn.detect(net, meta, file_path.encode()))

    logger.debug("Done with Task 1 for file {0}".format(file_path))
    return partial_output


def task_2(file_path: str) -> str:
    logger.debug("Performing task 2 for file {0}".format(file_path))
       
    if(("chair" or "table" and "sink") or 'refrigerator' or "toaster" or 'oven' or 'microwave')
        
        out = "kitchen"
        

    else if("car" or"bench" or "bicycle" or "motorbike" or "bus" or "train" or "truck" or "boat" or "traffic light" or "bird" or "kite")
        
        out = "home"
        
    else if("sofa" or "tvmonitor")
        
        out="salon"
        
    else if("chair" and "diningtable")
        
        out="dining room"
        
    else if("bed")
        
        out="bedroom"
        
    else if(("sink" and "toilet") or "toilet" or "toothbrush")
        
        out="bathroom"
        
    else if("chair")
        
        line = random.choice([random.choice(kitchen) + random.choice(salon) + random.choice(dining room)])
        
    else if("dining table")
        
        line = random.choice([random.choice(kitchen) + random.choice(salon) + random.choice(dining room)])
        
    else if("dining table")
        
        line = random.choice([random.choice(kitchen) + random.choice(bathroom)])
        
    else
        
        line = random.choice([random.choice(kitchen) + random.choice(salon) + random.choice(dining room)+ random.choice(bathroom)])
    
    logger.debug("Done with Task 1 for file {0}".format(file_path))
    return labels_task2[random.randrange(len(labels_task2))]


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
    

