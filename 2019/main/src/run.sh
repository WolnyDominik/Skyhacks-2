#!/bin/bash
for (( c=$1; c<$1+$3; c++ ))
do  
   eval "python3 ./answer_generator.py $c $2" &
done
wait
echo "[Done] The program finished!"
