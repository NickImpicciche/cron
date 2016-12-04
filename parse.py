from json import loads,dumps
from subprocess import call
import datetime

NUM_POSTS = 5

f = open("insta.out")
s = f.read()
insta = loads(s)
i = 0
posts = []
insta_url = 'https://instagram.com/taylorswift'
insta_image_url = 'static/website/images/icon/insta.png'
for (caption, unix_time, media_url, thumbnail, is_video, likes) in insta:
    time = datetime.datetime.fromtimestamp( int(unix_time) ).strftime('%Y-%m-%d')
    posts.append( [ caption, insta_url, time, media_url, insta_image_url, likes ] )

posts = posts[:NUM_POSTS]
sorted( posts, key=lambda x: x[2] ) #sort by unix_time
for i in range(NUM_POSTS):
    #saves output file to relevant place
    call( [ "wget", posts[i][3], "-O", "../src/website/static/website/images/icons/post"+str(i)+".jpg" ] )
f = open("../src/website/posts.out","w")
f.write( dumps(posts) )
