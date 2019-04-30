## GitHub repository dashboard

##### Authors
Kai Böhrnsen (bohrnsen@kth.se)
Felix Eder (felixed@kth.se)


##### About
This project has set up a dashboard that can be used to monitor the activity of a github repository, including forks, pull requests and so on. The main idé was to set up something for the hackathon mentioned in this [issue](https://github.com/KTH/devops-course/issues/118).

The dashboard is right now configured for this very repo, but see below for how to change this. See the building section below to see of to build this project.

##### Building
After cloning the repo, you need to install Laravel Homestead, which is done by following this [guide](https://laravel.com/docs/5.8/homestead).

After Homestead has been configured, navigate to the folder in which it was installed. Open the file "Homestead.yaml" in your favorite text editor. Under the section "folders", add the following lines of code:
`- map: ~/<location to cloned repo>`
`to: /home/vagrant/<prefered name of dashboard>`

Under the section sites, add the following lines of code:
`- map: <prefered name of dashboard>.test`
`to: /home/vagrant/<prefered name of dashboard>/public`
`schedule: true`

If there isn't one already, add a section `databases:` and add the following lines of code under it:
`- homestead`
`- <prefered name of dashboard>`

Save the file and close the editor. After this is done, run the following commands:
`vagrant up`
`vagrant ssh`

Then navigate into the folder with the name of your dashboard (should be the only folder available).

In the folder, run the following commands:
`art schedule:run`
`art websocket:serve`

Open another terminal navigate to Homestead directory and run
`vagrant ssh` once again. Then run:
`yarn run production`.

Open your web browser of choice and navigate to this site:
`<prefered name of dashboard>.test`

If this doesn't work, then instead navigate to:
`192.168.10.10`

Now you should be able to see the dashboard!

The websocket events of the dashboard should trigger every minute, but if you want to do it manually you can by following these commands:
`art list` - This will list all the available commands.

Then type whatever command you like:
`art <command>`

##### Configuring
By default, the dashboard points to this repository, but you can change it to whatever you like. Navigate to the .env file. On "GITHUB_USERNAME", enter the github-username which the repository you want to feature is connected to. Then enter your repo-name for "GITHUB_REPO".

As you can see, the .env file has a ton of other variables that can be set, feel free to mix around and see what you can do!

##### Miscellaneous
This project is in large part based on the Spatie dashboard [project](https://github.com/spatie/dashboard.spatie.be) and a lot of credit should be given them.
