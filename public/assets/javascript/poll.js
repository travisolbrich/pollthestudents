var $ = $ || {};
var document = document || {};

var POLL = POLL || {
    INFO: null,
    MODEL: null,
    MARSHALLER: null,
    REGISTRY: null,
    VIEW: null
};

POLL.INFO = {
    BaseUrl: ""
};

POLL.MODEL = {
    Poll: null,
    Choice: null,
    Answer: null
};

POLL.MODEL.Poll = (function () {
    'use strict';
    
    var Poll;
    
    Poll = function () {
        this.init();
    };
    
    Poll.prototype = {
        
        init: function () {
            this.identifier = null;
            this.prompt = "New Prompt";
            this.choices = [];
            this.answers = [];
        },
        
        getIdentifier: function () {
            return this.identifier;
        },
        
        setIdentifier: function (value) {
            if (value !== undefined) {
                this.identifier = value;
            }
        },
        
        isPublic: function () {
            return this.is_public;
        },
        
        setIsPublic: function (value) {
            if (value !== undefined) {
                this.is_public = value;
            }
        },
        
        getPrompt: function () {
            return this.prompt;
        },
        
        setPrompt: function (value) {
            if (value !== undefined) {
                this.prompt = value;
            }
        },
        
        getAnswers: function () {
            return this.answers;
        },
        
        setAnswers: function (value) {
            if (value !== undefined) {
                this.answers = value;
            }
        },
        
        getChoices: function () {
            return this.choices;
        },
        
        setChoices: function (value) {
            if (value !== undefined) {
                this.choices = value;
            }
        },
        
        getCreationDate: function () {
            return this.creation_date;
        },
        
        setCreationDate: function (value) {
            if (value !== undefined) {
                this.creation_date = value;
            }
        },
        
        getUpdatedDate: function () {
            return this.updated_date;
        },
        
        setUpdatedDate: function (value) {
            if (value !== undefined) {
                this.updated_date = value;
            }
        },
        
        update: function (data) {
            if (data !== null) {
                var choicesData = data.choices,
                    answersData = data.answers,
                    
                    choices = [],
                    choiceData,
                    choice,
                    
                    answers = [],
                    answerData,
                    answer,
                    
                    i;
                
                for (i = 0; i < choicesData.length; i += 1) {
                    choiceData = choicesData[i];
                    choice = new POLL.MODEL.Choice();
                    choice.update(choiceData);
                    choices.push(choice);
                }
                
                for (i = 0; i < answersData.length; i += 1) {
                    answersData = answersData[i];
                    answer = new POLL.MODEL.Answer();
                    answer.update(answerData);
                    answers.push(answer);
                }
                
                this.setAnswers(answers);
                this.setChoices(choices);
                this.setPrompt(data.prompt);
                this.setIsPublic(data.is_public);
                this.setCreationDate(data.creation_date);
                this.setUpdatedDate(data.updated_date);
            }
        }
    };
    
    return Poll;
}());

POLL.MODEL.Choice = (function () {
    'use strict';
    
    var Choice;
    
    Choice = function () {
        this.init();
    };
    
    Choice.prototype = {
        
        init: function () {
            this.id = null;
            this.poll_id = null;
            this.name = "New Choice";
        },
        
        getIdentifier: function () {
            return this.id;
        },
        
        setIdentifier: function (value) {
            if (value !== undefined) {
                this.id = value;
            }
        },
        
        getPollIdentifier: function () {
            return this.poll_id;
        },
        
        setPollIdentifier:  function (value) {
            if (value !== undefined) {
                this.poll_id = value;
            }
        },
        
        getName: function () {
            return this.name;
        },
        
        setName:  function (value) {
            if (value !== undefined) {
                this.name = value;
            }
        },
        
        update: function (data) {
            if (data !== null) {
                this.setName(data.name);
                this.identifier(data.id);
                this.pollIdentifier(data.poll_id);
            }
        }
    };
    
    return Choice;
}());

POLL.MODEL.Answer = (function () {
    'use strict';
    
    var Answer;
    
    Answer = function () {
        this.init();
    };
    
    Answer.prototype = {
        
        init: function () {
            this.identifier = null;
        },
        
        getIdentifier: function () {
            return this.id;
        },
        
        setIdentifier: function (value) {
            if (value !== undefined) {
                this.id = value;
            }
        },
        
        getPollId: function () {
            return this.poll_id;
        },
        
        setPollId:  function (value) {
            if (value !== undefined) {
                this.poll_id = value;
            }
        },
        
        getChoiceId: function () {
            return this.choice_id;
        },
        
        setChoiceId:  function (value) {
            if (value !== undefined) {
                this.choice_id = value;
            }
        },
        
        getStringAnswer: function () {
            return this.answer;
        },
        
        setStringAnswer:  function (value) {
            if (value !== undefined) {
                this.answer = value;
            }
        },
        
        update: function (data) {
            if (data !== null) {
                this.setIdentifier(data.id);
                this.setPollId(data.poll_Id);
                this.setChoiceId(data.choice_id);
            }
        }
    };
    
    return Answer;
}());

POLL.MARSHALLER = {
    PollMarshaller: null,
    ChoiceMarshaller: null,
    AnswerMarshaller: null
};

POLL.MARSHALLER.PollMarshaller = (function () {
    'use strict';
    
    var PollMarshaller;
    
    PollMarshaller = function () {};
    
    PollMarshaller.prototype = {
        
        marshall: function (data) {
            
            var polls,
                pollsData = data,
                
                pollData,
                poll,
            
                i;
            
            for (i = 0; i < pollsData.length; i += 1) {
                pollData = pollsData[i];
                poll = new POLL.MODEL.Poll();
                poll.update(pollData);
                polls.push(poll);
            }
            
            return polls;
        }
        
    };
    
    return PollMarshaller;
}());

POLL.MARSHALLER.AnswerMarshaller = (function () {
    'use strict';
    
    var AnswerMarshaller;
    
    AnswerMarshaller = function () {};
    
    AnswerMarshaller.prototype = {
        
        marshall: function (data) {
            
            var answers,
                answersData = data,
                
                answerData,
                answer,
            
                i;
            
            for (i = 0; i < answersData.length; i += 1) {
                answerData = answersData[i];
                answer = new POLL.MODEL.Answer();
                answer.update(answerData);
                answers.push(answer);
            }
            
            return answers;
        }
        
    };
    
    return AnswerMarshaller;
}());

POLL.MARSHALLER.ChoiceMarshaller = (function () {
    'use strict';
    
    var ChoiceMarshaller;
    
    ChoiceMarshaller = function () {};
    
    ChoiceMarshaller.prototype = {
        
        marshall: function (data) {
            
            var choices,
                choicesData = data,
                
                choice,
                choiceData,
            
                i;
            
            for (i = 0; i < choicesData.length; i += 1) {
                choiceData = choiceData[i];
                choice = new POLL.MODEL.Choice();
                choice.update(choiceData);
                choices.push(choice);
            }
            
            return choices;
        }
        
    };
    
    return ChoiceMarshaller;
}());

POLL.REGISTRY = {
    Registry: null,
    PollRegistry: null,
    ChoiceRegistry: null,
    AnswerRegistry: null
};

POLL.REGISTRY.Registry = {
    
    timeout: 3000,
    
    create: function (data, url, callback, error) {
        'use strict';
        
        var jsonData = JSON.stringify(data);
        
        $.ajax({
            headers : {
                'Accept' : 'application/json',
                'Content-Type' : 'application/json'
            },
            type : "POST",
            url : url,
            data: jsonData,
            dataType : 'json',
            timeout: POLL.REGISTRY.Registry.timeout,
            success : callback,
            error : error
        });
    },
    
    read: function (url, parameters, callback, error) {
        'use strict';
        
        $.ajax({
            headers : {
                'Accept' : 'application/json'
            },
            type : "GET",
            url : url,
            data: parameters,
            timeout: POLL.REGISTRY.Registry.timeout,
            success : callback,
            error : error
        });
    },
    
    search: function (url, parameters, callback, error) {
        'use strict';
        
        $.ajax({
            headers : {
                'Accept' : 'application/json'
            },
            type : "GET",
            url : url,
            data: parameters,
            timeout: POLL.REGISTRY.Registry.timeout,
            success : callback,
            error : error
        });
    }
};

POLL.REGISTRY.PollRegistry = (function () {
    'use strict';
    
    var PollRegistry,
        POLL_URL = (POLL.INFO.BaseUrl + "/poll"),
        CREATE_URL = (POLL_URL),    //POST  
        READ_URL = (POLL_URL),      //GET
        SEARCH_URL = (POLL_URL),      //GET
        UPDATE_URL = (POLL_URL),    //PUT
        DELETE_URL = (POLL_URL);    //DELETE
    
    PollRegistry = function () {};
    
    PollRegistry.prototype = {
        
        create: function (poll, callback, error) {
            POLL.REGISTRY.Registry.create(poll, CREATE_URL, callback, error);
        },
        
        read: function (identifier, callback, error) {
            POLL.REGISTRY.Registry.create(READ_URL, {"identifier" : identifier}, callback, error);
        },
        
        search: function (parameters, callback, error) {
            POLL.REGISTRY.Registry.create(SEARCH_URL, parameters, callback, error);
        }
        
    };
    
    return PollRegistry;
}());

POLL.REGISTRY.AnswerRegistry = (function () {
    'use strict';
    
    var AnswerRegistry,
        POLL_URL = (POLL.INFO.BaseUrl + "/answer"),
        CREATE_URL = (POLL_URL),    //POST  
        READ_URL = (POLL_URL),      //GET
        SEARCH_URL = (POLL_URL),      //GET
        UPDATE_URL = (POLL_URL),    //PUT
        DELETE_URL = (POLL_URL);    //DELETE
    
    AnswerRegistry = function () {};
    
    AnswerRegistry.prototype = {
        
        create: function (answer, callback, error) {
            POLL.REGISTRY.Registry.create(answer, CREATE_URL, callback, error);
        },
        
        read: function (identifier, callback, error) {
            POLL.REGISTRY.Registry.create(READ_URL, {"identifier" : identifier}, callback, error);
        }

    };
    
    return AnswerRegistry;
}());

POLL.REGISTRY.ChoiceRegistry = (function () {
    'use strict';
    
    var ChoiceRegistry,
        POLL_URL = (POLL.INFO.BaseUrl + "/choice"),
        CREATE_URL = (POLL_URL),    //POST  
        READ_URL = (POLL_URL),      //GET
        SEARCH_URL = (POLL_URL),      //GET
        UPDATE_URL = (POLL_URL),    //PUT
        DELETE_URL = (POLL_URL);    //DELETE
    
    ChoiceRegistry = function () {};
    
    ChoiceRegistry.prototype = {
        
        create: function (choice, callback, error) {
            POLL.REGISTRY.Registry.create(choice, CREATE_URL, callback, error);
        },
        
        read: function (identifier, callback, error) {
            POLL.REGISTRY.Registry.create(READ_URL, {"identifier" : identifier}, callback, error);
        }

    };
    
    return ChoiceRegistry;
}());